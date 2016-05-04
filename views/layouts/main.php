<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="wrap">
        <?php
        NavBar::begin([
            'brandLabel' => 'Юнит-НН',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-fixed-top  navbar-default',
            ],
        ]); ?>
        <div class="navbar-info navbar-info-phone hidden-sm hidden-md hidden-xs">
            <div class="hidden-md header-phone">
                <?= Html::a('+7 (831) 220-94-33', 'tel:+78312209433') ?>
            </div>
        </div>
        <?php echo Nav::widget([
            'options' => ['class' => 'nav navbar-nav navbar-right'],
            'items' => [
                ['label' => 'Главная', 'url' => ['/']],
                ['label' => 'О компании', 'url' => ['/page/about']],
                ['label' => 'Акции', 'url' => ['/page/promo']],
                ['label' => 'Цены', 'url' => ['/page/price']],
                ['label' => 'Контакты', 'url' => ['/page/contact']],
                ['label' => 'Доставка', 'url' => ['/page/transportation']],
            ],
        ]); ?>
        <?php NavBar::end(); ?>

        <div class="container">
            <div class="breadcrumbs-block" style="background-color: #04859d;">
                <div class="pull-left">
                    <p><?= Html::encode($this->title) ?></p>
                </div>
                <div class="pull-right">
                    <?php
                    if (Yii::$app->controller->action->id !== 'index')
                    {echo Breadcrumbs::widget([
                        'homeLink' => ['label' => 'Главная', 'url' => '/'],
                        'links' => $this->params['breadcrumbs'],
                    ]);}
                    ?>
                </div>
            </div>
        </div>
        <div class="clear"></div>

        <div class="container">
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <a href="/site/contact" class="pull-left">Написать нам сообщение</a>

            <p class="pull-right">&copy; 2011–2015 Все права защищены</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>