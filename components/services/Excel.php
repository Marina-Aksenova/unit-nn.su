<?php
namespace app\components\services;

use yii;
use yii\console\Exception as ConsoleException;

class Excel extends yii\base\Component
{
	public static function import()
	{
		$i = 2; // Номер строки документа с которой начинается обработка.
		$errorRows = [];

		$transaction = Yii::$app->db->beginTransaction();

		try {
			// Обработка файла.
			/** @var \PHPExcel_Reader_Abstract $reader */
			$reader = \PHPExcel_IOFactory::createReaderForFile('test.xls');
			$reader->setReadDataOnly(true);
			$PHPExcel = $reader->load('test.xls');
			$worksheet = $PHPExcel->getSheet(0);

			// Проверка есть в файле строки для обработки.
			if ($worksheet->getHighestRow() < 2) {
				throw new yii\base\UserException('ERR_FILE_IS_EMPTY');
			}

			// Обработка строк.
			for ($i = 2; $i <= $worksheet->getHighestRow(); $i++) {
				echo '<pre>'; var_dump(
                    trim($worksheet->getCell('A' . $i)->getValue()),
                    trim($worksheet->getCell('B' . $i)->getValue()),
                    trim($worksheet->getCell('C' . $i)->getValue()),
                    trim($worksheet->getCell('D' . $i)->getValue()),
                    trim($worksheet->getCell('E' . $i)->getValue()),
                    trim($worksheet->getCell('F' . $i)->getValue()),
                    trim($worksheet->getCell('J' . $i)->getValue()),
                    trim($worksheet->getCell('H' . $i)->getValue()),
                    trim($worksheet->getCell('I' . $i)->getValue()),
                    trim($worksheet->getCell('J' . $i)->getValue()),
                    trim($worksheet->getCell('K' . $i)->getValue()),
                    trim($worksheet->getCell('L' . $i)->getValue()),
                    trim($worksheet->getCell('M' . $i)->getValue()),
                    trim($worksheet->getCell('N' . $i)->getValue()),
                    trim($worksheet->getCell('O' . $i)->getValue())
                );
			}

			$transaction->commit();
		} catch (\Exception $exception) {
			// Если было вызвано исключение во время проведения транзакции, то отменяю изменения в базе данных.
			$transaction->rollBack();
			throw $exception;
		}

		return true;
	}

	public function consoleImport($path, array $points)
	{
		// Номер строки документа с которой начинается обработка
		$i = 2;
		$errorRows = [];
		$pointWorkplaces = [];

		// Получение существующих категорий
		$categories = [];
		foreach (CategoryModel::find()->active()->all() as $category) {
			$categories[strtolower($category->name)] = $category;
		}

		// Поиск связок точка-цех, у которых цех - обязательный, для
		// дальнейшего привязывания продуктов к цеху по-умолчанию для каждой точки
		foreach ($points as $point) {
			/** @var PointWorkplaceModel $defaultPointWorkplace */
			if (!$defaultPointWorkplace = PointWorkplaceModel::find()
				->from(['cw' => PointWorkplaceModel::tableName()])
				->active()
				->innerJoin(['w' => WorkplaceModel::tableName()], 'cw.[[workplace_id]] = w.[[id]]')
				->where(['w.required' => 1, 'point_id' => $point->id])
				->one()
			) {
				throw new ConsoleException('Default point workplace not found');
			}

			$pointWorkplaces[] = $defaultPointWorkplace;
		}

		$transaction = Yii::$app->db->beginTransaction();

		try {

			// Получение единицы измерения пол-умолчания
			/** @var MeasureModel $defaultMeasure */
			if (!$defaultMeasure = MeasureModel::find()->where([MeasureModel::tableName() . '.[[alias]]' => MeasureModel::ITEM])->active()->one()) {
				throw new ConsoleException('Не найден единица измерения штуки!');
			}

			// Обработка файла
			/** @var \PHPExcel_Reader_Abstract $reader */
			$reader = \PHPExcel_IOFactory::createReaderForFile($path);
			$reader->setReadDataOnly(true);
			$PHPExcel = $reader->load($path);
			$worksheet = $PHPExcel->getSheet(0);

			// Проверка есть в файле строки для обработки
			if ($worksheet->getHighestRow() < 2) {
				throw new ConsoleException('There is only ' . $worksheet->getHighestRow() . ' row(s) found');
			}

			// Обработка строк
			for ($i = 2; $i <= $worksheet->getHighestRow(); $i++) {
				if (($code = trim($worksheet->getCell('A' . $i)->getValue())) &&
					($name = trim($worksheet->getCell('B' . $i)->getValue())) &&
					($price = trim($worksheet->getCell('D' . $i)->getValue()))
				) {
					// Обработка категории
					$categoryObject = null;
					if ($category = trim($worksheet->getCell('C' . $i)->getValue())) {
						if (!isset($categories[strtolower($category)])) {
							$categoryObject = new CategoryModel([
								'name' => $category,
							]);
							if (!$categoryObject->save()) {
								$errorRows[$i]['category'] = $categoryObject->errors;
								continue;
							}
							$categories[strtolower($category)] = $categoryObject;
						} else {
							$categoryObject = $categories[strtolower($category)];
						}
					}

					// Создание и сохранение продукта
					$product = new ProductModel([
						'code' => $code,
						'name' => $name,
						'price' => $price,
						'price_cost' => $price,
						'measure_id' => $defaultMeasure->id,
					]);
					if ($categoryObject) {
						$product->category_id = $categoryObject->id;
					}
					if (!$product->save()) {
						$errorRows[$i]['product'] = $product->errors;
						continue;
					}

					// Создание сязок продукт-точка-цех
					foreach ($pointWorkplaces as $pointWorkplace) {
						$productPointWorkplace = new ProductPointWorkplaceModel([
							'product_id' => $product->id,
							'point_workplace_id' => $pointWorkplace->id,
						]);
						if (!$productPointWorkplace->save()) {
							$errorRows[$i]['product-point-workplace'] = $productPointWorkplace->errors;
							continue;
						}
					}
				} else {
					$errorRows[$i] = 'Data undefined: |' .
						($worksheet->getCell('A' . $i)->getValue() ? $worksheet->getCell('A' . $i)->getValue() : '???????') . ' | ' .
						($worksheet->getCell('B' . $i)->getValue() ? $worksheet->getCell('B' . $i)->getValue() : '???????') . ' | ' .
						($worksheet->getCell('C' . $i)->getValue() ? $worksheet->getCell('C' . $i)->getValue() : '???????') . ' | ' .
						($worksheet->getCell('D' . $i)->getValue() ? $worksheet->getCell('E' . $i)->getValue() : '???????') . ' |';
				}
			}

		} catch (\Exception $exception) {
			$message = ' (' . $exception->getMessage() . ')';
			$errorRows[$i] = '[ERROR] ' . (
				empty(DooglysException::$errorCodes[$exception->getCode()])
					? $message
					: DooglysException::$errorCodes[$exception->getCode()] . $message
				);
		}

		if ($errorRows) {
			$transaction->rollBack();
		} else {
			$transaction->commit();
		}

		return $errorRows;
	}
}