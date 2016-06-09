<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);

$this->registerJs("
    $('.menu-item').each(function(index, item) {
        $(item).on('mouseenter', function() {
            var item = $(this);
            item.css('background-position', '10px 0');
        });    
        $(item).on('mouseleave', function() {
            var item = $(this);
            item.css('background-position', '0 0');
        });    
    });
");
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="оргтехника, тонер, картридж, вал, ракель, принтер, заправка картриджей, ремонт принтера, снпч, струйный принтер, лазерный принтер">
    <meta name="description" content="Продажа расходных материалов для ремонта оргтехники и заправки картриджей">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title . ' - Юнит-НН') ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="/images/logo.png" style="height:40px;">',
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
            ['label' => 'Магазин', 'url' => ['/page/price']],
            ['label' => 'Доставка', 'url' => ['/page/delivery']],
            ['label' => 'Распродажа', 'url' => ['/page/sale']],
            ['label' => 'Контакты', 'url' => ['/page/contacts']],
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
                    <div class="item active">
                        <img src="/images/slider/1.png" title="Продажа расходных материалов" class="img-responsive">
                    </div>
                    <div class="item">
                        <img src="/images/slider/2.png" title="Фотовалы, ракеля и чипы" class="img-responsive">
                    </div>
                    <div class="item">
                        <img src="/images/slider/3.png" title="Тонеры и чернила" class="img-responsive">
                    </div>
                    <div class="item">
                        <img src="/images/slider/4.png" title="СНПЧ и ПЗК" class="img-responsive">
                    </div>
                    <div class="item">
                        <img src="/images/slider/5.png" title="Совместимые струйные и лазерные картриджи" class="img-responsive">
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

        <?= $content ?>
    <?php } else { ?>

    <div class="container-fluid main-page-title-container">
        <div class="main-page-title">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
    </div>

    <div class="container margin-top-20">
        <div class="col-lg-3 col-md-4 hidden-sm hidden-xs">
            <div class="menu-item menu-item-delivery">
                <a href="/delivery"></a>
            </div>
            <div class="menu-item menu-item-consultations">
                <a href="/contact"></a>
            </div>
            <div class="menu-item menu-item-sales">
                <a href="/sale"></a>
            </div>
        </div>
        <div class="col-lg-9 col-md-8 font-14">
            <?= $content ?>
        </div>
    </div>

    <?php } ?>

</div>

<footer class="footer">
    <div class="container">
        <a href="/contact" class="pull-left">Написать нам</a>

        <p class="pull-right">&copy; 2016 Юнит-НН</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
