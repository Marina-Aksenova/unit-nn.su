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
    <meta name="keywords"
          content="оргтехника, тонер, картридж, вал, ракель, принтер, заправка картриджей, ремонт принтера, снпч, струйный принтер, лазерный принтер">
    <meta name="description" content="Продажа расходных материалов для ремонта оргтехники и заправки картриджей">
    <link rel="shortcut icon" href="/favicon.ico"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="/images/logo.png">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-fixed-top navbar-default',
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
            ['label' => 'Главная', 'url' => ['/page/index']],
            ['label' => 'О компании', 'url' => ['/page/about']],
            ['label' => 'Акции', 'url' => ['/page/promo']],
            ['label' => 'Цены', 'url' => ['/page/price']],
            ['label' => 'Доставка', 'url' => ['/page/delivery']],
            ['label' => 'Распродажа', 'url' => ['/page/sale']],
            ['label' => 'Контакты', 'url' => ['/page/contact']],
        ],
    ]); ?>
    <?php NavBar::end(); ?>

    <?php if (Yii::$app->controller->action->id === 'index') { ?>
        <div class="container-fluid carousel-container">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="4"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div
                        class="item active"
                        style="background: transparent url(/images/slider/1.png) no-repeat 50% 0"
                        title="Продажа расходных материалов"
                    >
                    </div>
                    <div
                        class="item"
                        style="background: transparent url(/images/slider/2.png) no-repeat 50% 0"
                        title="Фотовалы, ракеля и чипы"
                    >
                    </div>
                    <div
                        class="item"
                        style="background: transparent url(/images/slider/3.png) no-repeat 50% 0"
                        title="Тонеры и чернила"
                    >
                    </div>
                    <div
                        class="item"
                        style="background: transparent url(/images/slider/4.png) no-repeat 50% 0"
                        title="СНПЧ и ПЗК"
                    >
                    </div>
                    <div
                        class="item"
                        style="background: transparent url(/images/slider/5.png) no-repeat 50% 0"
                        title="Совместимые струйные и лазерные картриджи"
                    >
                    </div>
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Предыдущий</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Следующий</span>
                </a>
            </div>
        </div>
    <?php } ?>
    <?= $content ?>

</div>

<footer class="footer">
    <div class="container">
        <a href="/site/contact" class="pull-left">Написать нам</a>

        <p class="pull-right">&copy; 2016 Юнит-НН</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
