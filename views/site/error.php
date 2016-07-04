<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Ошибка!';
$error = nl2br(Html::encode($message));
?>
<div class="site-error">
    <?php
        Yii::$app->mailer->compose()
            ->setFrom('support@unit-nn.ru')
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject($error)
            ->setHtmlBody($exception->getTraceAsString())
            ->send();
    ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= $error ?>
    </div>

    <p>
        Ошибка во время обработки запроса. Мы уже занимаемся решением этой проблемы.
    </p>

</div>
