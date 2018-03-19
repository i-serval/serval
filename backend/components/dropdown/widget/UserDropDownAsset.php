<?php

namespace backend\components\dropdown\widget;

use yii\web\AssetBundle;


class UserDropDownAsset extends AssetBundle
{

    public $baseUrl = '@web';

    public $sourcePath = __DIR__ . '/assets';

    public $css = [
        'css/dropdown.css',
    ];

    public $js = [
        'js/dropdown.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
