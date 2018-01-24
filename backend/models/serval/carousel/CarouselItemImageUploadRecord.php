<?php

namespace backend\models\serval\carousel;


class CarouselItemImageUploadRecord extends \common\models\serval\file\FileUploadRecord
{

    public function __construct(array $config = [])
    {

        parent::__construct($config);

        $this->setCategory('carousel/image');

    }

}
