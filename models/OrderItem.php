<?php

namespace app\models;

use app\components\BaseActiveRecord;
use app\components\queries\BaseQuery;
use yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $order_id
 * @property float $amount
 * @property string $date_create
 * @property string $date_change
 *
 * @property Order $order
 * @property Product $product
 */
class OrderItem extends BaseActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id'], 'required'],
            [['order_id'], 'exist', 'targetClass' => Order::className(), 'targetAttribute' => 'id'],

            [['product_id'], 'required'],
            [['product_id'], 'exist', 'targetClass' => Product::className(), 'targetAttribute' => 'id'],

            [['amount'], 'required'],
            [['amount'], 'integer', 'min' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Количество',
        ];
    }

    /**
     * @return BaseQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * @return BaseQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
