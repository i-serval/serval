<?php

namespace common\models\serval\carousel;

use Yii;
use yii\db\ActiveRecord;
use common\models\serval\carousel\CarouselItemImageRecord;


class CarouselItemRecord extends ActiveRecord
{

    public $order;
    public $use_count;
    public $is_used;

    public static function tableName()
    {
        return '{{%carousel_item}}';
    }

    public function rules()
    {
        return [
            ['image_id', 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
        ];
    }

    public function getImage()
    {
        return $this->hasOne(CarouselItemImageRecord::className(), ['id' => 'image_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'image_id' => 'Image',
        ];
    }

    public function getImageUrl()
    {

        if ($this->image != null) {
            return $this->image->getFileUrl();
        } else {
            return '/img/no_image.png';
        }

    }

    public function delete()
    {

        $count_of_use = Yii::$app->db->createCommand("SELECT count(id) FROM carousel_carousel_item WHERE carousel_item_id = :carousel_item_id")
            ->bindValue(':carousel_item_id', $this->id)
            ->queryScalar();

        if( $count_of_use > 0 ) {

            Yii::$app->session->setFlash('warning', Yii::t('carousel', 'Slide used in sliders, detach it before removing from sliders'));
            return false;

        }

        if ($this->image !== null) {
            $this->image->delete();
        }

        return parent::delete();

    }

}
