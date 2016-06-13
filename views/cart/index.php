<?php
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
        <div class="panel-body">
            <div class="row">
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
                                    'attribute' => 'amount',
                                    'label' => 'Количество',
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
                <a href="/cart/submit" class="btn btn-primary">Заказать</a>
                <?php } else { ?>
                    Ваша корзина пуста
                <?php } ?>
            </div>
        </div>
    </div>
</div>
