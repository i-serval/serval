<?php

namespace common\models\serval\carousel;


class CarouselItemImageRecord extends \common\models\serval\file\FileRecord
{

    public static function tableName()
    {
        return '{{%file}}';
    }

}
