<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
            'brandLabel' => '<img src="/images/logo.jpg">',
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
                ['label' => 'Доставка', 'url' => ['/page/delivery']],
            ],
        ]); ?>
        <?php NavBar::end(); ?>

        <div class="container-fluid breadcrumbs-block-bg">
            <div class="container breadcrumbs-block">
                <div class="pull-left">
                    <p><?= Html::encode($this->title) ?></p>
                </div>
                <div class="pull-right">
                    <?php
                    if (Yii::$app->controller->action->id !== 'index') {
                        echo Breadcrumbs::widget([
                            'homeLink' => ['label' => 'Главная', 'url' => '/'],
                            'links' => $this->params['breadcrumbs'],
                        ]);
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php if (Yii::$app->controller->action->id === 'index') { ?>
            <div class="container-fluid">
                <div class="container">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="/images/slider/1.png" alt="Продажа расходных материалов" title="Продажа расходных материалов">
                            </div>
                            <div class="item">
                                <img src="/images/slider/2.png" alt="Фотовалы, ракеля и чипы" title="Фотовалы, ракеля и чипы">
                            </div>
                            <div class="item">
                                <img src="/images/slider/3.png" alt="Тонеры и чернила" title="Тонеры и чернила">
                            </div>
                            <div class="item">
                                <img src="/images/slider/4.png" alt="СНПЧ и ПЗК" title="СНПЧ и ПЗК">
                            </div>
                            <div class="item">
                                <img src="/images/slider/5.png" alt="Совместимые струйные и лазерные картриджи" title="Совместимые струйные и лазерные картриджи">
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
            </div>
        <?php } ?>

        <div class="container margin-top-20">
            <div class="col-lg-3 col-md-4 hidden-sm hidden-xs">
                <div class="menu-item menu-item-actions">
                    <a href="/promo"></a>
                </div>
                <div class="menu-item menu-item-delivery">
                    <a href="/delivery"></a>
                </div>
                <div class="menu-item menu-item-consultations">
                    <a href="/consultation"></a>
                </div>
                <div class="menu-item menu-item-sales">
                    <a href="/sale"></a>
                </div>
            </div>
            <div class="col-lg-9 col-md-8 font-14">
                <?= $content ?>
            </div>
        </div>

    </div>

    <footer class="footer">
        <div class="container">
            <a href="/site/contact" class="pull-left">Написать нам сообщение</a>

            <p class="pull-right">&copy; 2016 Все права защищены</p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
