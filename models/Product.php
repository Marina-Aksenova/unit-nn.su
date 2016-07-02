<?php

namespace app\models;

use app\components\BaseActiveRecord;
use app\components\services\BaseService;
use yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $title
 * @property string $article
 * @property string $catalog_number
 * @property string $price_dealer
 * @property string $delivery
 * @property integer $brand_id
 * @property string $stock
 * @property string $date_create
 * @property string $date_change
 * 
 * @property Brand $brand
 */
class Product extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 155],

            [['article'], 'string', 'max' => 50],

            [['catalog_number'], 'string', 'max' => 50],

            [['price_dealer'], 'double'],

            [['delivery'], 'integer', 'min' => 1],

            [['stock'], 'integer', 'min' => 0],

            [['description'], 'string'],

            [['brand_id'], 'exist', 'targetClass' => Brand::className(), 'targetAttribute' => 'id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'price_dealer' => 'Цена',
            'date_create' => 'Date Create',
            'date_change' => 'Date Change',
        ];
    }

    public function getBrand()
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }
}
