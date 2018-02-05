<?php

namespace backend\assets\carousel;

use yii\web\AssetBundle;


class CarouselAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/carousel/carousel.css',
    ];

}
