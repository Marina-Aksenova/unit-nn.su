<?php

namespace app\modules\admin\components;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/assets';
    public $css = [
        'fonts/PT-Sans/style.css',
        'js/static/jquery-ui/jquery-ui.min.css',
//        'js/static/jquery-ui-sortable/jquery-ui.theme.min.css',
//        'js/static/jquery-ui-sortable/jquery-ui.structure.min.css',
        'css/admin.css',
    ];
    public $js = [
        'js/static/tinymce/tinymce.min.js',
        'js/static/jquery-ui/jquery-ui.min.js',
        'js/modal.js',
        'js/admin.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}