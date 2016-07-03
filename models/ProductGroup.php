<?php

namespace app\models;

use app\components\BaseActiveRecord;
use yii;
use yii\db\Query;

/**
 * This is the model class for table "product_group".
 *
 * @property integer $id
 * @property string $title
 * @property string $date_create
 * @property string $date_change

 * @property Product[] $products
 */
class ProductGroup extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'trim'],
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

    public static function getTree()
    {
        $data = [];

        /** @var ProductGroup $productGroup */
        foreach (static::find()->all() as $productGroup) {
            $nodes = [];
            $brands = ProductBrand::find()
                ->innerJoin(Product::tableName(), 'product.brand_id = product_brand.id')
                ->innerJoin(static::tableName(), 'product.group_id = product_group.id')
                ->where(['product_group.id' => $productGroup->id])
                ->groupBy(['product_brand.id'])
                ->all();

            /** @var ProductBrand $brand */
            foreach ($brands as $brand) {
                $nodes[] = [
                    'text' => $brand->title,
                    'productGroupId' => $productGroup->id,
                    'productBrandId' => $brand->id,
                ];
            }

            $data[] = [
                'text' => $productGroup->title,
                'nodes' => $nodes,
                'state' => [
                    'expanded' => false,
                ],
            ];
        }

        return $data;
    }

    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['group_id' => 'id']);
    }
}
