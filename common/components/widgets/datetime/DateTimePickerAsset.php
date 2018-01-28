<?php

namespace common\components\widgets\datetime;

use yii\web\AssetBundle;


class DateTimePickerAsset extends AssetBundle
{

    public $baseUrl = '@web';

    public $sourcePath = __DIR__ . '/assets';

    public $css = [
        'css/bootstrap-datetimepicker.min.css',
        'css/datetimepicker.css',
    ];

    public $js = [
        'js/moment-with-locales.min.js',        // important moment before datetimepicker
        'js/bootstrap-datetimepicker.min.js',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];

}
