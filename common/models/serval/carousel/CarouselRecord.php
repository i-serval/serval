<?php

namespace common\models\serval\carousel;

use \common\models\serval\carousel\CarouselItemRecord;


class CarouselRecord extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%carousel}}';
    }

    public function rules()
    {
        return [
            [['created', 'updated', 'activate_at', 'is_active'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'created' => 'Created',
            'updated' => 'Updated',
            'activate_at' => 'Time of activation',
            'is_active' => 'Is Active',
        ];
    }

    public function getCarouselItems()
    {
        return $this->hasMany(CarouselItemRecord::className(), ['id' => 'carousel_item_id'])
            ->viaTable('carousel_carousel_item', ['carousel_id' => 'id']);
    }

}
