<?php
namespace app\components\validators;

use app\components\services\Validator as ValidatorService;

class Phone extends BaseValidator
{
    public $message;

    public function getMessage()
    {
        return $this->message ? $this->message : 'Формат телефона неверен';
    }

    public function validateAttribute($model, $attribute)
    {
        if (!$result = ValidatorService::phone($model->$attribute)) {
            $this->addError($model, $attribute, $this->getMessage());
        } else {
            $model->$attribute = $result;
        }
    }
}