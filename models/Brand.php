<?php

namespace app\models;

use app\components\BaseActiveRecord;
use yii;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $title
 * @property string $date_create
 * @property string $date_change
 */
class Brand extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'date_create' => 'Date Create',
            'date_change' => 'Date Change',
        ];
    }
}
