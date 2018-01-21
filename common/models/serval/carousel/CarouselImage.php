<?php

namespace common\models\serval\carousel;

use \common\models\serval\file\ServalFile;

class CarouselImage extends ServalFile
{

   public function rules()
    {

        return [

            [ ['file'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'minWidth' => 1125, 'maxWidth' => 1125, 'minHeight' => 600, 'maxHeight' => 600, 'on' => 'create' ],
            [ ['file'], 'image', 'extensions' => 'png, jpg', 'minWidth' => 1125, 'maxWidth' => 1125, 'minHeight' => 600, 'maxHeight' => 600, 'on' => 'update' ]

        ];
    }

}
