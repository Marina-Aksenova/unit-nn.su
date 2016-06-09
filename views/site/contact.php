<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Консультация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-container site-contact">

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Спасибо, что написали. Мы ответим Вам как можно скорее.
        </div>

        <p>
            Вы можете вернуться на <a href="/">главную страницу</a> или выбрать другой раздел сайта.
        </p>

    <?php else: ?>

        <p>
            Если у Вас есть какие-либо вопросы, пожалуйста, заполните следующую форму для связи с нами.
            Мы обязательно свяжимся с Вами. Спасибо.
        </p>

        <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

        <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'subject') ?>

        <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-9">{input}</div></div>',
    ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    <?php endif; ?>
</div>

