<?php

namespace backend\components\menu\widget;

use yii\web\AssetBundle;


class ServalMenuAsset extends AssetBundle
{

    public $baseUrl = '@web';

    public $sourcePath = __DIR__ . '/assets';

    public $css = [
        'css/menu.css',
    ];

    public $js = [
        'js/menu.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
