<?php

namespace backend\models\serval\carousel;

use common\models\serval\carousel\CarouselItemRecord;


class CarouselItemManager
{
    public function __construct()
    {

    }

    public function getModelByID( $id )
    {

        return CarouselItemRecord::find()->Where( ['id' => $id ] )->one();

    }

}
