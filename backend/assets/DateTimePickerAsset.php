<?php

namespace backend\assets;

use yii\web\AssetBundle;


class DateTimePickerAsset extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@bower/eonasdan-bootstrap-datetimepicker/build';

    public $css = [
        'css/bootstrap-datetimepicker.min.css',
    ];

    public $js = [
        'js/bootstrap-datetimepicker.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'backend\assets\MomentAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
