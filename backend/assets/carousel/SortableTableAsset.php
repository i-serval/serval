<?php

namespace backend\assets\carousel;

use yii\web\AssetBundle;


class SortableTableAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/carousel/sortable-table.js',
    ];
    public $depends = [
        'yii\jui\JuiAsset',

    ];
}
