<?php

namespace common\models\serval\carousel;

use Yii;

class CarouselRecord extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'carousel';
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
            'activate_at' => 'Activate At',
            'is_active' => 'Is Active',
        ];
    }
}
