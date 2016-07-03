<?php
use app\models\Product;
use app\models\ProductBrand;
use app\models\ProductGroup;
use app\modules\admin\models\UploadForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/** @var View $this */
/** @var UploadForm $model */
?>

<div class="container margin-top-60">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php if (Yii::$app->getSession()->hasFlash('success')) { ?>
                <div class="alert alert-success text-center">
                    <strong><?= Yii::$app->getSession()->getFlash('success') ?></strong>
                    <div>брендов <?= ProductBrand::find()->count() ?>, групп товаров <?= ProductGroup::find()->count() ?>, товаров <?= Product::find()->count() ?></div>
                </div>
            <?php } ?>

            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
                <?= $form->field($model, 'file')->fileInput()->hint('Выберите файл для загрузки в формате Microsoft Excel (*.xls, *.xlsx)') ?>
                <button>Загрузить</button>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
