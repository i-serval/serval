<?php

namespace common\models;

use common\models\ServalFile;
use Yii;


class Carousel extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'carousel';
    }

    public function rules()
    {
        return [
            [['order', 'image_id'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
        ];
    }

    public function getImage()
    {
        return $this->hasOne( ServalFile::className(), [ 'id' => 'image_id'] );
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'order' => 'Order',
            'image_id' => 'Image ID',
        ];
    }

    public function getImageUrl(){

        if( $this->image != null ) {
            return $this->image->getImageUrl();
        } else{
            return '/img/no_image.png';
        }

    }

    public function delete()
    {

        if( $this->image !== null) {
            $this->image->delete();
        }

        parent::delete();

    }

}
