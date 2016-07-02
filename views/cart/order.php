<?php
use app\components\services\BaseService;
use app\models\OrderItem;
use app\models\Product;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider ArrayDataProvider */
/* @var $order array */
/* @var $product Product */

$total = 0;
$models = $dataProvider->getModels();
if (!empty($models)) {
    foreach ($models as $orderItem) {
        $total += $orderItem['price'] * $orderItem['amount'];
    }
}

$this->title = 'Заказ';
?>

<div class="panel panel-default">
    <div class="panel-body content-padding">
        <?php if (Yii::$app->getSession()->hasFlash('success')) { ?>
            <div class="alert alert-success text-center">
                <strong><?= Yii::$app->getSession()->getFlash('success') ?></strong>
            </div>
        <?php } ?>
        <div>
            <?= GridView::widget([
                'layout' => "{items}\n{pager}",
                'showFooter' => true,
                'tableOptions' => [
                    'class' => 'table',
                ],
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'product_title',
                        'enableSorting' => false,
                    ],
                    [
                        'label' => 'Цена',
                        'value' => function (OrderItem $orderItem){
                            return BaseService::getFormattedPrice($orderItem->price);
                        },
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['class' => 'text-center',],
                    ],
                    [
                        'attribute' => 'amount',
                        'enableSorting' => false,
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['class' => 'text-center',],
                    ],
                    [
                        'label' => 'Сумма',
                        'value' => function (OrderItem $orderItem){
                            return BaseService::getFormattedPrice($orderItem->price * $orderItem->amount);
                        },
                        'contentOptions' => ['class' => 'text-center'],
                        'headerOptions' => ['class' => 'text-center',],
                        'footerOptions' => ['class' => 'text-center',],
                        'footer' => Html::tag('strong', BaseService::getFormattedPrice($total)),
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
