<?php

namespace backend\assets\carousel;

use yii\web\AssetBundle;


class AttachSlideAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/carousel/attach-slide.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
