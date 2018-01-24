<?php

namespace backend\models\serval\carousel;

use common\models\serval\carousel\CarouselRecord;


class CarouselManager
{
    public function __construct()
    {

    }

    public function getModelByID($id)
    {

        return CarouselRecord::find()->Where(['id' => $id])->one();

    }

    public function getActiveCarousel()
    {

        return CarouselRecord::find()->Where(['is_active' => 1])->one();

    }

    public function tryDeactivateAllExeptCurrent($current_carousel)
    {

        $active_carousels = CarouselRecord::find()->Where(['<>', 'id', $current_carousel->id])->andWhere(['is_active' => 1])->All();

        foreach ($active_carousels as $carousel) {
            $carousel->is_active = 0;
            $carousel->save();
        }

    }

}
