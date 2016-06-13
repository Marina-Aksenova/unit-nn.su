<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $orders array */

$this->title = 'История заказов - Юнит-НН';
?>

<div class="container margin-top-60">
    <?php foreach ($orders as $order) { ?>
        <?= $order->id ?>
    <?php } ?>
</div>

