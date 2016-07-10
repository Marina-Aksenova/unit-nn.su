<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception \Exception */

use yii\helpers\Html;

$previousExceptionMessage = '';
$previousExceptionError = '';
if ($previousExcweption = $exception->getPrevious()) {
    $previousExceptionMessage = $previousExcweption->getTraceAsString();
    $previousExceptionError = $previousExcweption->getMessage();
}
$this->title = 'Ошибка!';
$error = nl2br(Html::encode($message));
$traces = $exception->getTraceAsString() . '<br><br>Предыдущее исключение:<br>' . $previousExceptionMessage;
?>
<div class="site-error">
    <?php
        Yii::$app->mailer->compose()
            ->setFrom('support@unit-nn.ru')
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject($error . ' | ' . $previousExceptionError)
            ->setHtmlBody(nl2br($traces))
            ->send();
    ?>

    <div class="alert alert-danger">
        <?= $error ?>
    </div>

    <p>
        Произошла ошибка во время обработки запроса. Мы уже занимаемся решением этой проблемы.
    </p>

</div>
