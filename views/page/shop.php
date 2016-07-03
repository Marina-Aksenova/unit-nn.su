<?php
use app\assets\AppAsset;
use app\components\services\BaseService;
use app\models\ProductBrand;
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

$this->registerJsFile('/js/shop/pages/shop.js', ['position' => View::POS_END]);
$this->registerJsFile('/js/shop/components/shopGrid.js', ['position' => View::POS_END]);
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
                                <div class="form-group">
                                    <label for="shop-search-input">Поиск по названию товара</label>
                                    <input type="text" id="shop-search-input" class="form-control shop-search-input" placeholder="Начните набирать название товара">
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
                            'title',
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
