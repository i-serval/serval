<?php

namespace backend\assets;

use yii\web\AssetBundle;


class MomentAsset extends AssetBundle
{
    public $baseUrl = '@web';
    public $sourcePath = '@bower/moment/min';

    public $js = [
        'moment-with-locales.min.js',
    ];

}
