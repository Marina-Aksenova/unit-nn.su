<?php
use app\models\Product;
use yii\data\ActiveDataProvider;
use yii\grid\Column;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider ActiveDataProvider */
/* @var $brands array */
/* @var $order array */
/* @var $product Product */

$this->registerJsFile('/js/shop/pages/shop.js', ['position' => View::POS_END]);
$this->title = 'Магазин';
?>

<div class="shop-container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <?php foreach ($brands as $brand) { ?>
                        <div>
                            <?= $brand->title ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-lg-9 col-md-9">
                    <?php Pjax::begin(); ?>
                    <?= GridView::widget([
                        'rowOptions' => function (Product $product) use($order) {
                            $rowOptions = [];

                            if ($amount = ArrayHelper::getValue($order, $product->id, '')) {
                                $rowOptions['class'] = 'success';
                            }

                            return $rowOptions;
                        },
                        'showHeader' => false,
                        'layout' => "{items}\n{pager}",
                        'tableOptions' => [
                            'class' => 'table',
                        ],
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            'title',
                            [
                                'class' => Column::className(),
                                'content' => function(Product $product) use($order) {
                                    $amount = ArrayHelper::getValue($order, $product->id, 0);
                                    $spanMinus = Html::tag('span', '', ['class' => 'glyphicon glyphicon-minus']);
                                    $buttonMinus = Html::tag('div', $spanMinus, ['class' => 'btn btn-default btn-xs button-minus']);
                                    $spanPlus = Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']);
                                    $buttonPlus = Html::tag('div', $spanPlus, ['class' => 'btn btn-default btn-xs button-plus']);
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
