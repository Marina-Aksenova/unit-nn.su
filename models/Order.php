<?php

namespace app\models;

use app\components\BaseActiveRecord;
use app\components\queries\BaseQuery;
use yii;

/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $date_create
 * @property string $date_change
 *
 * @property OrderItem[] $items
 */
class Order extends BaseActiveRecord
{
    public static function tableName()
    {
        return 'order';
    }

    public function rules()
    {
        return [
            [['user_id'], 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }

    public function getItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }
}
