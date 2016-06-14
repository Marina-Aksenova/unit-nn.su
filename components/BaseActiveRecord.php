<?php
namespace app\components;

use app\components\queries\BaseQuery;
use app\components\services\BaseService;
use yii;
use yii\base\UserException;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;
use yii\helpers\ArrayHelper;

/**
 * Base model
 *
 * @property string $id
 * @property string $date_created
 * @property string $date_updated
 * @property string $date_deleted
 */
class BaseActiveRecord extends ActiveRecord
{
    public static function find()
    {
        return new BaseQuery(get_called_class());
    }

    public static function findOne($condition)
    {
        if (is_numeric($condition)) {
            $condition = [static::field('id') => $condition];
        }

        return parent::findOne($condition);
    }

    public static function field($field)
    {
        return '{{' . static::tableName() . '}}.[[' . $field . ']]';
    }

    public function validateOrError($attributeNames = null, $clearErrors = true)
    {
        if (!$this->validate($attributeNames, $clearErrors)) {
            throw new UserException($this->getTheVeryFirstError());
        }
    }

    public function getTheVeryFirstError()
    {
        return BaseService::getTheVeryFirstError($this);
    }

    public function saveOrError($runValidation = true, $attributeNames = null)
    {
        if (!$this->save($runValidation, $attributeNames)) {
            throw new UserException($this->getTheVeryFirstError());
        }
    }

    public function removeOrError()
    {
        if (!parent::delete()) {
            throw new UserException('Систманая ошибка');
        }
    }

    public function remove()
    {
        parent::delete();
    }

    public function getIntOrNull($value)
    {
        return BaseService::getIntOrNull($value);
    }

    public function getDoubleOrNull($value)
    {
        return BaseService::getFloatOrNull($value);
    }

    public function getFloatOrNull($value)
    {
        return BaseService::getFloatOrNull($value);
    }
}