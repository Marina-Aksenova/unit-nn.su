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
 * @property integer $group_id
 * @property string $stock
 * @property string $date_create
 * @property string $date_change
 * 
 * @property ProductBrand $brand
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
            [['title'], 'trim'],
            [['title'], 'string', 'max' => 155],

            [['article'], 'trim'],
            [['article'], 'string', 'max' => 50],

            [['catalog_number'], 'trim'],
            [['catalog_number'], 'string', 'max' => 50],

            [['price_dealer'], 'required'],
            [['price_dealer'], 'double'],

            [['delivery'], 'default', 'value' => 0],
            [['delivery'], 'integer', 'min' => 1],

            [['stock'], 'default', 'value' => 0],
            [['stock'], 'integer', 'min' => 0],

            [['description'], 'trim'],
            [['description'], 'string'],

            [['brand_id'], 'required'],
            [['brand_id'], 'exist', 'targetClass' => ProductBrand::className(), 'targetAttribute' => 'id'],

            [['group_id'], 'required'],
            [['group_id'], 'exist', 'targetClass' => ProductGroup::className(), 'targetAttribute' => 'id'],
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
        return $this->hasOne(ProductBrand::className(), ['id' => 'brand_id']);
    }
}
