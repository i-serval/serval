<?php

namespace backend\models\serval\carousel;

use common\models\serval\carousel\CarouselItemRecord;
use Yii;


class CarouselItemManager
{
    public function __construct()
    {

    }

    public function getModelByID( $id )
    {

        return CarouselItemRecord::find()->Where( ['id' => $id ] )->one();

    }

    public function updateSlidesOrder( $update_data, $carousel_id)
    {

        foreach ( $update_data as $update_item ){

            Yii::$app->db->createCommand("UPDATE carousel_carousel_item SET `order` = :order WHERE carousel_item_id = :carousel_item_id AND carousel_id = :carousel_id")
                ->bindValue(':order', $update_item['order'])
                ->bindValue(':carousel_item_id', $update_item['id'])
                ->bindValue(':carousel_id', $carousel_id)
                ->execute();

        }

    }

}
