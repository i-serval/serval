<?php

namespace backend\models\serval\carousel\form;

use backend\models\serval\carousel\CarouselItemImageUploadRecord;
use common\models\serval\carousel\CarouselItemRecord;


class CarouselItemForm extends \yii\base\Model
{

    public $id;
    public $title;
    public $description;
    public $order;
    public $carousel_image;

    public $carousel_item_instance;

    public function __construct(array $config = [])
    {

        parent::__construct($config);

    }

    public function rules()
    {

        return [
            [['title', 'description'], 'string', 'max' => 255],
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

        if ($carousel_image->save()) {

            $carousel_item->link('image', $carousel_image);  // like $carousel_item->image_id = $carousel_image->id;

        } else {

            return null;
        }

        return $carousel_item->save() ? $carousel_item : null;

    }

    public function update($carousel_item)
    {
        $this->scenario = 'update';

        $carousel_image = (new CarouselItemImageUploadRecord())
            ->initFrom($carousel_item->image)
            ->bind($this, 'carousel_image');

        if (!$this->validate()) {

            return null;
        }

        $carousel_item->title = $this->title;
        $carousel_item->description = $this->description;

        if ($carousel_image->save()) { //if set new image save it and link to carousel item

            $carousel_item->link('image', $carousel_image);

        }

        return $carousel_item->save() ? $carousel_item : null;

    }

    public function getImageUrl()
    {

        if (!isset($this->carousel_item_instance) || !isset($this->carousel_item_instance->image)) {
            return null;
        }

        return $this->carousel_item_instance->image->getFileUrl();

    }

    public function isNewRecord()
    {
        if ($this->id === null) {
            return true;
        }

        return false;
    }

}
