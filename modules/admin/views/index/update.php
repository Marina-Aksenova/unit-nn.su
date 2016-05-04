<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="container">
    <?php
    $form = ActiveForm::begin([
        'id' => 'update-form',
        'options' => ['class' => 'form-horizontal'],
    ]) ?>
    <?= $form->field($page, 'name') ?>
    <?= $form->field($page, 'text')->textarea(['rows' => 20]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end() ?>
</div>
