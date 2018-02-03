<?php

namespace common\models\serval\helper;

use Yii;
use Yii\helpers\Html;

class GridViewHelper
{

    public static function yesNo($value, $tag_options = [] )
    {

        if ($value === null) {
            return '-';
        }

        if ($value == 'yes' || $value == 'Yes' || $value == 1 || $value == 'YES') {

            if( isset($tag_options['class'])){
                $tag_options['class'] .= ' green';
            } else {
                $tag_options['class'] = 'green';
            }

            return Html::tag('span', Yii::t('serval', 'Yes'), $tag_options);

        } else {

            if( isset($tag_options['class'])){
                $tag_options['class'] .= ' red';
            } else {
                $tag_options['class'] = 'red';
            }

            return Html::tag('span', Yii::t('serval', 'No'), $tag_options);

        }

    }

    public static function DateTimeRowsWithIcons($value, $date_format = null, $time_format = null, $date_class = null, $time_class = null)
    {

        $date_format = $date_format ?? Yii::$app->formatter->dateFormat;
        $time_format = $time_format ?? Yii::$app->formatter->timeFormat;

        $time_class = $time_class ?? 'grid-time-icon';
        $date_class = $time_class ?? 'grid-date-icon';

        $date = '-';
        $time = '-';

        if ($value != null) {

            $date = Yii::$app->formatter->asDate($value, $date_format);
            $time = Yii::$app->formatter->asTime($value, $time_format);

        }else{

            return '';

        }

        return '<div class="grid-date-time-wrapper">'.
                    '<span class="glyphicon glyphicon-calendar" class="' . $date_class . '"></span>' . $date .' <br />'.
                    '<span class="glyphicon glyphicon-time" class="' . $time_class . '"></span>' . $time . ''.
                '</div>';

    }

    public static function DateTimeRows($value, $date_format = null, $time_format = null, $date_class = null, $time_class = null)
    {

        $date_format = $date_format ?? Yii::$app->formatter->dateFormat;
        $time_format = $time_format ?? Yii::$app->formatter->timeFormat;

        $time_class = $time_class ?? 'grid-time-icon';
        $date_class = $time_class ?? 'grid-date-icon';

        $date = '-';
        $time = '-';

        if ($value != null) {

            $date = Yii::$app->formatter->asDate($value, $date_format);
            $time = Yii::$app->formatter->asTime($value, $time_format);

        }

        return '<div class="grid-date-time-wrapper">' . $date .' <br />' . $time . '</div>';

    }

    public static function wrapToTag( $value = null, $tag_options = [] )
    {

        if( $value === null ){
            $value = '-';
        }

        return Html::tag('span', $value, $tag_options);

    }


}
