<?php

namespace app\models;

use app\components\BaseActiveRecord;
use app\components\queries\BaseQuery;
use yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $product_title
 * @property integer $order_id
 * @property integer $amount
 * @property float $price
 * @property string $date_create
 * @property string $date_change
 *
 * @property Order $order
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

            [['product_title'], 'required'],
            [['product_title'], 'string', 'max' => 255],

            [['amount'], 'required'],
            [['amount'], 'integer', 'min' => 1],

            [['price'], 'required'],
            [['price'], 'double', 'min' => 0.01],
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
            'product_title' => 'Название',
            'price' => 'Цена',
        ];
    }

    /**
     * @return BaseQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
