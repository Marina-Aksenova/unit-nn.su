<?php
namespace app\components\services;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use yii;

class Validator extends BaseService
{
    public static function phone($phone)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $numberProto = $phoneUtil->parse($phone, BaseService::getCountryCode());
            if (!$phoneUtil->isValidNumber($numberProto)) {
                return false;
            }
        } catch (NumberParseException $e) {
            return false;
        }

        return $numberProto->getNationalNumber();
    }
}
