<?php

namespace backend\models\serval\carousel;

use common\models\serval\carousel\CarouselRecord;


class CarouselManager
{
    public function __construct()
    {

    }

    public function getModelByID( $id )
    {

        return CarouselRecord::find()->Where( ['id' => $id ] )->one();

    }

}
