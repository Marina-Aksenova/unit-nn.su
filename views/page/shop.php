<?php
use app\assets\AppAsset;
use app\components\services\BaseService;
use app\models\Product;
use app\models\ProductGroup;
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
/* @var $productGroups array */
/* @var $order array */
/* @var $product Product */
/* @var $productGroup ProductGroup */
/* @var $filterModel Product */

$this->title = 'Магазин';

var_dump(Yii::$app->security->generatePasswordHash('Yfifj,edm090')); die('-=END=-');

$this->registerJsFile('/js/shop/pages/shop.js', ['depends' => AppAsset::className()]);
$this->registerJsFile('/js/shop/components/shopGrid.js', ['depends' => AppAsset::className()]);
$this->registerCssFile('/js/static/treeview/src/css/bootstrap-treeview.css', ['position' => View::POS_BEGIN]);

$this->registerJs("
    var treeData = " . Json::encode(ProductGroup::getTree()) . ";
", View::POS_END);
?>

<div class="shop-container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div id="tree"></div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="shop-search">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <input type="text" id="shop-search-title" class="form-control" placeholder="Название">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default search-clear" type="button"><span class="glyphicon glyphicon-remove"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="input-group">
                                            <input type="text" id="shop-search-price" class="form-control" placeholder="Цена">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default search-clear" type="button"><span class="glyphicon glyphicon-remove"></span></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="margin-top-20">
                                    <span class="button-checkbox">
                                        <button id="shop-search-stock" type="button" class="btn" data-color="default">В наличии</button>
                                        <input type="checkbox" id="shop-search-stock-input" class="hidden"/>
                                    </span>
                                    <span class="button-checkbox">
                                        <button id="shop-search-delivery" type="button" class="btn" data-color="default">Под заказ</button>
                                        <input type="checkbox" id="shop-search-delivery-input" class="hidden"/>
                                    </span>
                                    <span id="loading">
                                        <img src="/images/loading.gif">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php Pjax::begin([
                        'id' => 'products-grid-pjax',
                        'clientOptions' => ['method' => 'POST'],
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
                            [
                                'attribute' => 'group_id',
                                'headerOptions' => [
                                    'class' => 'hidden',
                                ],
                                'contentOptions' => ['class' => 'hidden'],
                            ],
                            [
                                'attribute' => 'brand_id',
                                'headerOptions' => [
                                    'class' => 'hidden',
                                ],
                                'contentOptions' => ['class' => 'hidden'],
                            ],
                            [
                                'attribute' => 'title',
                                'content' => function (Product $product) use ($order) {
                                    $amount = ArrayHelper::getValue($order, $product->id, 0);
                                    $spanMinus = Html::tag('span', '', ['class' => 'glyphicon glyphicon-minus']);
                                    $buttonMinus = Html::tag('button', $spanMinus, ['class' => 'btn btn-default btn-xs button-minus']);
                                    $spanPlus = Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']);
                                    $buttonPlus = Html::tag('button', $spanPlus, ['class' => 'btn btn-default btn-xs button-plus']);
                                    $input = Html::input('text', 'amount', $amount, ['class' => 'form-control input-sm input-amount']);
                                    $amount = Html::tag('div', $buttonMinus . $input . $buttonPlus, ['class' => 'component-amount']);

                                    return '
                                        <div class="hidden-xs">
                                            ' . $product->title . '
                                        </div>
                                        <div class="panel panel-default hidden-lg hidden-md hidden-sm">
                                            <div class="panel-heading" role="tab" id="product-heading-' . $product->id . '">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" href="#product-collapse-' . $product->id . '" aria-expanded="true" aria-controls="product-collapse-' . $product->id . '">
                                                        ' . $product->title . '
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="product-collapse-' . $product->id . '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="product-heading-' . $product->id . '">
                                                <div class="panel-body">
                                                    <div class="pull-right">' . $amount . '</div>
                                                    <div>В наличии: ' . $product->stock . '</div>
                                                    <div>Под заказ: ' . $product->delivery . '</div>
                                                    <div class="text-center">
                                                        <strong style="font-size: 24px;">' . BaseService::getFormattedPrice($product->price_dealer) . '</strong>
                                                        <img src="/images/ruble.png" class="ruble2">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                },
                            ],
                            [
                                'attribute' => 'price_dealer',
                                'headerOptions' => [
                                    'class' => 'text-center hidden-xs',
                                ],
                                'contentOptions' => ['class' => 'text-center hidden-xs'],
                                'value' => function (Product $product){
                                    return BaseService::getFormattedPrice($product->price_dealer);
                                },
                            ],
                            [
                                'label' => 'В наличии',
                                'attribute' => 'stock',
                                'headerOptions' => [
                                    'class' => 'text-center hidden-xs',
                                ],
                                'contentOptions' => ['class' => 'text-center hidden-xs'],
                            ],
                            [
                                'label' => 'Под заказ',
                                'attribute' => 'delivery',
                                'headerOptions' => [
                                    'class' => 'text-center hidden-xs',
                                ],
                                'contentOptions' => ['class' => 'text-center hidden-xs'],
                            ],
                            [
                                'class' => Column::className(),
                                'header' => 'Количество',
                                'headerOptions' => [
                                    'class' => 'text-center hidden-xs',
                                ],
                                'contentOptions' => ['class' => 'text-center hidden-xs'],
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
                            'shopGrid'
                        ], function (ShopGrid) {
                            var shopGrid = new ShopGrid();
                            shopGrid.render();
                        });
                    "); ?>

                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
