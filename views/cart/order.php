<?php
use app\models\OrderItem;
use app\models\Product;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider ArrayDataProvider */
/* @var $order array */
/* @var $product Product */

$this->title = 'Заказ';
?>

<div class="panel panel-default">
    <div class="panel-body content-padding">
        <?php if (Yii::$app->getSession()->hasFlash('success')) { ?>
            <div class="alert alert-success">
                <?= Yii::$app->getSession()->getFlash('success') ?>
            </div>
        <?php } ?>
        <h2>Детали вашего заказа:</h2>
        <div>
            <?= GridView::widget([
                'layout' => "{items}\n{pager}",
                'tableOptions' => [
                    'class' => 'table',
                ],
                'dataProvider' => $dataProvider,
                'columns' => [
                    'product_title',
                    [
                        'value' => function (OrderItem $orderItem){
                            return number_format($orderItem->price, 2, ',', ' ');
                        },
                    ],
                    'amount',
                    [
                        'value' => function (OrderItem $orderItem){
                            return number_format($orderItem->price * $orderItem->amount, 2, ',', ' ');
                        },
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
