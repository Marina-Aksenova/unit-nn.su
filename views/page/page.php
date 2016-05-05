<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = $page->name . ' - Юнит-НН';
?>

<div class="container page-container">
    <div class="page-title-container">
        <?= $page->name ?>
    </div>
    <?= $page->text ?>
</div>
