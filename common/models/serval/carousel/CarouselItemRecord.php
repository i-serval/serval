<?php

namespace common\models\serval\carousel;

use Yii;
use yii\db\ActiveRecord;
use common\models\serval\carousel\CarouselItemImageRecord;


class CarouselItemRecord extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%carousel_item}}';
    }

    public function rules()
    {
        return [
            [['order', 'image_id'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            ['order', 'required'],
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
            'order' => 'Order',
            'image_id' => 'Image',
        ];
    }

    public function getImageUrl(){

        if( $this->image != null ) {
            return $this->image->getFileUrl();
        } else{
            return '/img/no_image.png';
        }

    }

    public function delete()
    {

        if( $this->image !== null ){
            $this->image->delete();
        }

        return parent::delete();

    }

}
