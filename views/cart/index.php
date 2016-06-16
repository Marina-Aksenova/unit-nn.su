<?php
use app\components\services\BaseService;
use app\models\OrderItem;
use app\models\Product;
use yii\bootstrap\ActiveForm;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $dataProvider ArrayDataProvider */
/* @var $order array */
/* @var $product Product */

$total = 0;
if (!empty($dataProvider->getModels())) {
    foreach ($dataProvider->getModels() as $orderItem) {
        $total += $orderItem['price'] * $orderItem['amount'];
    }
}

$this->registerJsFile('/js/shop/pages/shop.js', ['position' => View::POS_END]);
$this->title = 'Корзина';
?>

<div class="shop-container">
    <div class="panel panel-default">
        <div class="panel-body content-padding">
            <?php if ($dataProvider->getCount()) { ?>
            <div>
                <?= GridView::widget([
                    'layout' => "{items}\n{pager}",
                    'tableOptions' => [
                        'class' => 'table',
                    ],
                    'showFooter' => true,
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
                            'headerOptions' => [
                                'class' => 'text-center',
                            ],
                            'contentOptions' => ['class' => 'text-center'],
                            'label' => 'Цена',
                        ],
                        [
                            'attribute' => 'amount',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => [
                                'class' => 'text-center',
                            ],
                            'label' => 'Количество',
                        ],
                        [
                            'value' => function ($orderItem) use(&$total) {
                                return BaseService::getFormattedPrice($orderItem['price'] * $orderItem['amount']);
                            },
                            'label' => 'Сумма',
                            'contentOptions' => ['class' => 'text-center'],
                            'headerOptions' => ['class' => 'text-center',],
                            'footerOptions' => ['class' => 'text-center',],
                            'footer' => Html::tag('strong', BaseService::getFormattedPrice($total)),
                        ],
                    ],
                ]); ?>

                <?php $submitButton = Html::button('Заказать', ['type' => 'submit', 'class' => 'btn btn-primary']); ?>
                <?php if (Yii::$app->getUser()->getIdentity()) {
                    echo $submitButton;
                } else { ?>
                    <?= Html::beginForm('/cart/submit', 'post', ['class' => 'form-inline']) ?>
                        <div class="form-group <?= ($error ? 'has-error' : '') ?>">
                            <label class="control-label" for="email">Электропочта для связи</label>
                            <input name="email" type="text" class="form-control" id="email" placeholder="Электропочта">
                        </div>
                        <?= $submitButton ?>
                    <?= Html::endForm() ?>
                <?php } ?>
            </div>
            <?php } else { ?>
                Ваша корзина пуста
            <?php } ?>
        </div>
    </div>
</div>
