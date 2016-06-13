<?php

namespace app\modules\cabinet\components;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CabinetAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/cabinet/assets';
    public $css = [
        'css/cabinet.css'
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}