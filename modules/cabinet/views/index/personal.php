<?php
use app\components\services\BaseService;
use app\models\User;
use libphonenumber\PhoneNumberUtil;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user User */

$this->title = 'Личные данные - Юнит-НН';

$phoneUtil = PhoneNumberUtil::getInstance();
$numberProto = $phoneUtil->parse($user->phone, BaseService::getCountryCode());
$user->phone = $phoneUtil->format($numberProto, \libphonenumber\PhoneNumberFormat::INTERNATIONAL);
?>

<div class="bg-success">
    <?= Yii::$app->getSession()->getFlash('user_saved'); ?>
</div>

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
]); ?>
    <?= $form->field($user, 'first_name'); ?>
    <?= $form->field($user, 'second_name'); ?>
    <?= $form->field($user, 'third_name'); ?>
    <?= $form->field($user, 'email'); ?>
    <?= $form->field($user, 'phone'); ?>
    <?= $form->field($user, 'password')->passwordInput(); ?>
    <?= $form->field($user, 'address'); ?>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php $form->end(); ?>
