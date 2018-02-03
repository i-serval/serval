<?php

namespace backend\models\serval\carousel;

use common\models\serval\carousel\CarouselRecord;
use common\models\serval\helper\DateTimeHelper;

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

    public function tryDeactivateAllExeptCurrent($current_carousel_id)
    {

        $active_carousels = CarouselRecord::find()->Where(['<>', 'id', $current_carousel_id])->andWhere(['is_active' => 1])->All();

        foreach ($active_carousels as $carousel_item) {
            $carousel_item->is_active = 0;
            $carousel_item->save();
        }

        return $this;

    }

    public function setNullForExpiredActivationTime()
    {

        $with_expired_activation_time = CarouselRecord::find()->Where(['<=', 'activate_at', DateTimeHelper::getCurrentMysqlTimestamp()])->All();

        foreach ($with_expired_activation_time as $carousel_item) {
            $carousel_item->activate_at = null;
            $carousel_item->save();
        }

        return $this;

    }

}
