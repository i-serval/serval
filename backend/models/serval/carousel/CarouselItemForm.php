<?php

namespace backend\models\serval\carousel;

use backend\models\serval\carousel\CarouselItemImageUploadRecord;
use common\models\serval\carousel\CarouselItemRecord;


class CarouselItemForm extends \yii\base\Model
{

    public $id;
    public $title;
    public $description;
    public $order;
    public $carousel_image;

    public function __construct(array $config = [])
    {

        parent::__construct($config);

    }

    public function rules()
    {

        return [
            [['title', 'description'], 'string', 'max' => 255],
            ['order', 'required'],
            [['carousel_image'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'minWidth' => 1125, 'maxWidth' => 1125, 'minHeight' => 600, 'maxHeight' => 600, 'on' => 'create'],
            [['carousel_image'], 'image', 'extensions' => 'png, jpg', 'minWidth' => 1125, 'maxWidth' => 1125, 'minHeight' => 600, 'maxHeight' => 600, 'on' => 'update']
        ];

    }

    public function save()
    {

        $this->scenario = 'create';

        $carousel_image = (new CarouselItemImageUploadRecord())->bind($this, 'carousel_image');

        if (!$this->validate()) {
            return null;
        }

        $carousel_item = new CarouselItemRecord();
        $carousel_item->title = $this->title;
        $carousel_item->description = $this->description;
        $carousel_item->order = (int)$this->order;


        if ($carousel_image->save()) {

            $carousel_item->image_id = $carousel_image->id;

        } else {

            return null;
        }


        /*
                $r = $carousel_item->save();
                $errors =  $carousel_item->getErrors();

                $a = 234;*/

        return $carousel_item->save() ? $carousel_item : null;


    }

    public function isNewRecord()
    {
        if ($this->id === null) {
            return true;
        }

        return false;
    }

}
