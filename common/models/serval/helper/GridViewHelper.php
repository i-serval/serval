<?php

namespace common\models\serval\helper;

use Yii;

class GridViewHelper
{

    public static function yesNo($value)
    {

        if( $value === null ){
            return '-';
        }

        if( $value == 'yes' || $value == 'Yes' || $value == 1 || $value == 'YES' ) {

            return '<span class="green">' . Yii::t('serval', 'Yes') . '</span>';

        } else {

            return '<span class="red"> ' . Yii::t('serval', 'No') . '</span>';

        }

    }

}
