<?php

namespace app\components\services;

use yii;
use yii\base\Component;
use yii\base\Model;

class BaseService extends Component
{
    private static $languageToCountryCode = [
        'ru-RU' => 'RU',
        'ru_RU' => 'RU',
        'ru' => 'RU',
    ];

    public static function getCountryCode()
    {
        if (!empty(self::$languageToCountryCode[Yii::$app->language])) {
            return self::$languageToCountryCode[Yii::$app->language];
        }

        return Yii::$app->language;
    }

    public static function getTheVeryFirstError(Model $model)
    {
        $errors = $model->getErrors();
        $firstFieldErrors = reset($errors);

        return reset($firstFieldErrors);
    }

    public static function getIntOrNull($value)
    {
        return $value ? (int)$value : null;
    }

    public static function getFloatOrNull($value)
    {
        return $value ? (float)$value : null;
    }
}
