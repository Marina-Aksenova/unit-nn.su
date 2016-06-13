<?php

/* @var $this yii\web\View */
use app\models\Order;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $dataProvider ActiveDataProvider */
/* @var $order Order */

$this->title = 'Оформление заказа';
?>
<div class="order">
    <?php Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'product.title',
            'amount',
        ],
    ]); ?>
    <?php Pjax::end() ?>
</div>
