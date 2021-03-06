<?php

namespace backend\assets;

use yii\web\AssetBundle;


class ServalAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/serval-layout.css',
        'css/serval-bootstrap.css',
    ];
    public $js = [
        'js/serval.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
