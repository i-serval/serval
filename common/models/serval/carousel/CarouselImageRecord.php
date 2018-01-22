<?php

namespace common\models\serval\carousel;


class CarouselImageRecord extends \common\models\serval\file\FileUploadRecord
{

    public function rules()
    {

        return [

            [['file'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'minWidth' => 1125, 'maxWidth' => 1125, 'minHeight' => 600, 'maxHeight' => 600, 'on' => 'create'],
            [['file'], 'image', 'extensions' => 'png, jpg', 'minWidth' => 1125, 'maxWidth' => 1125, 'minHeight' => 600, 'maxHeight' => 600, 'on' => 'update']

        ];
    }

    public function __construct(array $config = [])
    {

        parent::__construct($config);

        $this->setCategory('carousel/image');

    }

}
