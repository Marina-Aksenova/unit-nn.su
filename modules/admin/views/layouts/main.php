<?php
use app\assets\AppAsset;
use app\modules\admin\components\AdminAsset;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/js/static/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

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
    <?php echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Главная', 'url' => ['/admin'], 'encode' => false],
            ['label' => '<span title="Выход" class="glyphicon glyphicon-log-out"></span>', 'url' => ['/site/logout'], 'encode' => false],
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container margin-top-60">

        <div class="panel panel-default">
            <div class="panel-body">
                <a href="/admin/index/update/1" class="btn btn-default">Главная</a>
                <a href="/admin/index/update/2" class="btn btn-default">О компании</a>
                <a href="/admin/index/update/3" class="btn btn-default">Акции</a>
                <a href="/admin/index/update/4" class="btn btn-default">Цены</a>
                <a href="/admin/index/update/5" class="btn btn-default">Контакты</a>
                <a href="/admin/index/update/6" class="btn btn-default">Доставка</a>
                <a href="/admin/index/update/7" class="btn btn-default">Консультации</a>
                <a href="/admin/index/update/8" class="btn btn-default">Распродажа</a>
            </div>
        </div>

    </div>
    
    <div class="wrap-page">
        <?= $content ?>
    </div>

</div>

<footer class="footer">
    <div class="container">
        <p class="pull-right">&copy; 2016 Все права защищены</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
