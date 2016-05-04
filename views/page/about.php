<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

$this->title = 'О компании';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
        <div class="col-sm-6 col-md-4">
                <h3><?= $page->name ?></h3>

                <div class="caption">
                        <h3><?= $page->text ?></h3>
                </div>
        </div>
</div>