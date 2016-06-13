<?php
use app\models\Page;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $page Page */

$this->title = $page->title;
?>

<div class="page-container">
    <?= $page->text ?>

    <?php if ($page->id === 5) { ?>
        <div class="map">
            <a class="dg-widget-link" href="http://2gis.ru/n_novgorod/firm/2674540559817860/center/43.999812,56.286764/zoom/16?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=bigMap">Посмотреть на карте Нижнего Новгорода</a><div class="dg-widget-link"><a href="http://2gis.ru/n_novgorod/center/43.999812,56.286764/zoom/16/routeTab/rsType/bus/to/43.999812,56.286764╎Юнит-НН, оптово-сервисная компания?utm_medium=widget-source&utm_campaign=firmsonmap&utm_source=route">Найти проезд до Юнит-НН, оптово-сервисная компания</a></div><script charset="utf-8" src="http://widgets.2gis.com/js/DGWidgetLoader.js"></script><script charset="utf-8">new DGWidgetLoader({"width":640,"height":600,"borderColor":"#a3a3a3","pos":{"lat":56.286764,"lon":43.999812,"zoom":16},"opt":{"city":"n_novgorod"},"org":[{"id":"2674540559817860"}]});</script><noscript style="color:#c00;font-size:16px;font-weight:bold;">Виджет карты использует JavaScript. Включите его в настройках вашего браузера.</noscript>
        </div>
    <?php } ?>
</div>
