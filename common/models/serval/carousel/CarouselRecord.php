<?php

namespace common\models\serval\carousel;

use Yii;
use yii\db\ActiveRecord;
use common\models\serval\carousel\CarouselImageRecord;


class CarouselRecord extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%carousel}}';
    }

    public function rules()
    {
        return [
            [['order', 'image'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            [['title', 'description', 'order'], 'required'],
            [['order'], 'number'],
        ];
    }

    public function getImage()
    {
        return $this->hasOne(CarouselImageRecord::className(), ['id' => 'image_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'order' => 'Order',
            'image' => 'Image',
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
