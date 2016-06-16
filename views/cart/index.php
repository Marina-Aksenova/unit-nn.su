<?php
use app\components\services\BaseService;
use app\models\Product;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $dataProvider ArrayDataProvider */
/* @var $order array */
/* @var $product Product */

$this->registerJsFile('/js/shop/pages/shop.js', ['position' => View::POS_END]);
$this->title = 'Корзина';
?>

<div class="shop-container">
    <div class="panel panel-default">
        <div class="panel-body content-padding">
            <h2>Детали вашего заказа:</h2>
            <?php if ($dataProvider->getCount()) { ?>
            <div>
                <?= GridView::widget([
                    'layout' => "{items}\n{pager}",
                    'tableOptions' => [
                        'class' => 'table',
                    ],
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'attribute' => 'product',
                            'label' => 'Название',
                        ],
                        [
                            'value' => function ($orderItem){
                                return BaseService::getFormattedPrice($orderItem['price']);
                            },
                            'label' => 'Цена',
                        ],
                        [
                            'attribute' => 'amount',
                            'label' => 'Количество',
                        ],
                        [
                            'value' => function ($orderItem){
                                return BaseService::getFormattedPrice($orderItem['price'] * $orderItem['amount']);
                            },
                            'label' => 'Сумма',
                        ],
                    ],
                ]); ?>
                <a href="/cart/submit" class="btn btn-primary">Заказать</a>
            </div>
        </div>
        <?php } else { ?>
            Ваша корзина пуста
        <?php } ?>
    </div>
</div>
