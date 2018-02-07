<?php

namespace common\models\serval\carousel;

use common\models\serval\carousel\CarouselItemRecord;
use common\models\serval\helper\DateTimeHelper;


class CarouselRecord extends \yii\db\ActiveRecord
{

    public $carousel_items_count;

    public static function tableName()
    {
        return '{{%carousel}}';
    }

    public function rules()
    {
        return [
            [['is_active'], 'string', 'max' => 3, 'min' => 2],
            [['created_at', 'updated_at', 'activate_at'], 'date', 'format' => 'php:Y-m-d H:i:s'],
            [['title', 'description'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'created_at' => 'Created',
            'updated_at' => 'Updated',
            'activate_at' => 'Time of Activation',
            'is_active' => 'Is Active',
        ];
    }

    public function getCarousel_items()   //simple relation via table
    {

        return $this->hasMany(CarouselItemRecord::className(), ['id' => 'carousel_item_id'])
            ->viaTable('carousel_carousel_item', ['carousel_id' => 'id']);

    }

    public function getCarousel_items_sorted()  //  use underscore for right property name, relation wit sorting on order in table carousel_carousel_item
    {

        return $this->hasMany(CarouselItemRecord::className(), ['id' => 'carousel_item_id'])
            ->viaTable('carousel_carousel_item', ['carousel_id' => 'id'])
            ->addSelect('`carousel_item`.*, carousel_carousel_item.order')
            ->leftJoin('carousel_carousel_item', 'carousel_item.id = carousel_carousel_item.carousel_item_id')
            ->Where('carousel_carousel_item.carousel_id = :current_carousel', [':current_carousel' => $this->id])
            ->orderBy(['carousel_carousel_item.order' => SORT_ASC]);

    }

    public function getCarouselItemsCounts()
    {

        return count($this->carousel_items);

    }

    public function setTitle($title)
    {

        $this->title = $title;
        return $this;

    }

    public function setDescription($description)
    {

        $this->description = $description;
        return $this;

    }

    public function setCreatedAt($data_time)
    {

        $this->created_at = DateTimeHelper::getMysqlTimestamp($data_time);
        return $this;

    }

    public function setUpdatedAt($data_time)
    {

        $this->updated_at = DateTimeHelper::getMysqlTimestamp($data_time);
        return $this;

    }

    public function setActivateAt($data_time)
    {

        $this->activate_at = DateTimeHelper::getMysqlTimestamp($data_time);
        return $this;

    }

    public function setIsActive($yes_no)
    {

        if (is_int($yes_no)) {

            if ($yes_no == 0) {
                $yes_no = 'no';
            }

            if ($yes_no == 1) {
                $yes_no = 'yes';
            }

        }

        $this->is_active = $yes_no;
        return $this;

    }

}
