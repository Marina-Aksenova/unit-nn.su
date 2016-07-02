<?php
namespace app\components\services;

use app\models\Brand;
use app\models\Product;
use yii;
use yii\base\UserException;

class Excel extends yii\base\Component
{
    public static function importPrice($filePath)
    {
        $i = 3; // Номер строки документа с которой начинается обработка.
        $errorRows = [];

        $transaction = Yii::$app->db->beginTransaction();

        try {
            // Обработка файла
            /** @var \PHPExcel_Reader_Abstract $reader */
            $reader = \PHPExcel_IOFactory::createReaderForFile($filePath);
            $reader->setReadDataOnly(true);
            $PHPExcel = $reader->load($filePath);
            $worksheet = $PHPExcel->getSheet(0);

            // Проверка есть в файле строки для обработки.
            if ($worksheet->getHighestRow() < 2) {
                throw new UserException('ERR_FILE_IS_EMPTY');
            }

            Product::deleteAll();
            Brand::deleteAll();

            // Обработка строк.
            $brand = null;
    		for (; $i <= $worksheet->getHighestRow(); $i++) {
                $priceDealer = $worksheet->getCell('H' . $i)->getValue();
                $article = $worksheet->getCell('F' . $i)->getValue();
                $title = $worksheet->getCell('D' . $i)->getValue();
                $stock = $worksheet->getCell('I' . $i)->getValue();
                $delivery = $worksheet->getCell('J' . $i)->getValue();

                // Обработка поля с брэндом
                if ($brandTitle = $worksheet->getCell('B' . $i)->getValue()) {
                    $brand = new Brand([
                        'title' => $brandTitle,
                    ]);
                    $brand->saveOrError();
                }

                if ($title) {
                    $product = new Product([
                        'title' => $title,
                        'article' => $article,
                        'price_dealer' => $priceDealer,
                        'delivery' => $delivery,
                        'stock' => $stock,
                        'brand_id' => $brand->id,
                    ]);
                    $product->saveOrError();
                }
            }

            $transaction->commit();
        } catch (\Exception $exception) {
            // Если было вызвано исключение во время проведения транзакции, то отменяю изменения в базе данных.
            $transaction->rollBack();
            throw $exception;
        }

        return true;
    }
}