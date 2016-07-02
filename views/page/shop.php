<?php
use app\components\services\BaseService;
use app\models\Brand;
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\grid\Column;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider ActiveDataProvider */
/* @var $brands array */
/* @var $order array */
/* @var $product Product */
/* @var $filterModel Product */

$this->title = 'Магазин';

$this->registerJsFile('/js/shop/pages/shop.js', ['position' => View::POS_END]);
$this->registerCssFile('/js/static/treeview/src/css/bootstrap-treeview.css', ['position' => View::POS_BEGIN]);

$tree = [];
/** @var Brand $brand */
foreach ($brands as $brand) {
    $tree[] = [
        'text' => $brand->title,
        'brandId' => $brand->id,
        'nodes' => $brand->getProductsForTree(),
        'state' => [
            'expanded' => false,
        ],
    ];
}

$this->registerJs("
        var treeData = " . Json::encode($tree) . ";
",
View::POS_BEGIN
);
?>

<div class="shop-container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <?php foreach ($brands as $brand) { ?>
                        <div id="tree"></div>
                    <?php } ?>
                </div>
                <div class="col-lg-9 col-md-9">
                    <?php Pjax::begin([
                        'id' => 'products-grid-pjax',
                    ]); ?>
                    <?= GridView::widget([
                        'id' => 'products-grid',
                        'rowOptions' => function (Product $product) use ($order){
                            $rowOptions = [
                                'data-price' => $product->price_dealer,
                            ];

                            if ($amount = ArrayHelper::getValue($order, $product->id, '')) {
                                $rowOptions['class'] = 'success';
                            }

                            return $rowOptions;
                        },
                        'layout' => "{items}\n{pager}",
                        'filterModel' => $filterModel,
                        'tableOptions' => [
                            'class' => 'table',
                        ],
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            'title',
                            'brand_id',
                            [
                                'attribute' => 'price_dealer',
                                'headerOptions' => [
                                    'class' => 'text-center',
                                ],
                                'contentOptions' => ['class' => 'text-center'],
                                'value' => function (Product $product){
                                    return BaseService::getFormattedPrice($product->price_dealer);
                                },
                            ],
                            [
                                'label' => 'В наличии',
                                'attribute' => 'stock',
                                'headerOptions' => [
                                    'class' => 'text-center',
                                ],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'label' => 'Под заказ',
                                'attribute' => 'delivery',
                                'headerOptions' => [
                                    'class' => 'text-center',
                                ],
                                'contentOptions' => ['class' => 'text-center'],
                            ],
                            [
                                'class' => Column::className(),
                                'header' => 'Количество',
                                'headerOptions' => [
                                    'class' => 'text-center',
                                ],
                                'contentOptions' => ['class' => 'text-center'],
                                'content' => function (Product $product) use ($order){
                                    $amount = ArrayHelper::getValue($order, $product->id, 0);
                                    $spanMinus = Html::tag('span', '', ['class' => 'glyphicon glyphicon-minus']);
                                    $buttonMinus = Html::tag('button', $spanMinus, ['class' => 'btn btn-default btn-xs button-minus']);
                                    $spanPlus = Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']);
                                    $buttonPlus = Html::tag('button', $spanPlus, ['class' => 'btn btn-default btn-xs button-plus']);
                                    $input = Html::input('text', 'amount', $amount, ['class' => 'form-control input-sm input-amount']);

                                    return Html::tag('div', $buttonMinus . $input . $buttonPlus, ['class' => 'component-amount']);
                                },
                            ],
                        ],
                    ]); ?>

                    <?php $this->registerJs("
                        requirejs([
                            'shop'
                        ], function (Shop) {
                            var shop = new Shop();
                            shop.render();
                        });
                    "); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
