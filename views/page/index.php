<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $pages array */

$this->title = 'Главная - Юнит-НН';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container main-page-container">
    <?= $page->text ?>
</div>