<?php

namespace backend\models\serval\carousel;

use Yii;
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

    public function getModelByIDWithSlides($id)
    {

        return CarouselRecord::find()
            ->joinWith('carousel_items.image')
            ->Where(['carousel.id' => $id])
            ->one();

    }

    public function getActiveCarousel()
    {

        return CarouselRecord::find()->Where(['is_active' => 1])->one();

    }

    public function tryDeactivateAllExeptCurrent($current_carousel_id)
    {

        Yii::$app->db->createCommand("UPDATE carousel SET is_active = 'no' WHERE id != :current_id AND is_active = 'yes'")
            ->bindValue(':current_id', $current_carousel_id)
            ->execute();

        return $this;

    }

    public function setNullForExpiredActivationTime()
    {

        Yii::$app->db->createCommand("UPDATE carousel SET activate_at = NULL WHERE activate_at <= :current_time")
            ->bindValue(':current_time', DateTimeHelper::getCurrentMysqlTimestamp())
            ->execute();

        return $this;

    }

}
