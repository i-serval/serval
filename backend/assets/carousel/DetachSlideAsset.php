<?php

namespace backend\assets\carousel;

use yii\web\AssetBundle;


class DetachSlideAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/carousel/detach-slide.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
