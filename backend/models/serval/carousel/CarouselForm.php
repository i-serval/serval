<?php

namespace backend\models\serval\carousel;

use yii\base\Model;
use common\models\serval\carousel\CarouselImageRecord;
use common\models\serval\carousel\CarouselRecord;


class CarouselForm extends Model
{

    public $carousel;
    public $carousel_image;

    public function __construct(array $config = [])
    {

        parent::__construct($config);

        $this->carousel = new CarouselRecord();
        $this->carousel_image = new CarouselImageRecord();

    }

    public function load($data, $formName = null)
    {

        if ($this->carousel->load($data) && $this->carousel_image->load($data)) {

            return true;

        }

        return false;

    }

    public function save()
    {

        $this->initScenario();

        $is_valid = $this->carousel->validate();
        $is_valid = $this->carousel_image->validate() && $is_valid;

        if ($is_valid) {

            if ($this->carousel_image->save(false)) {

                $this->carousel->image_id = $this->carousel_image->id;

                if ($this->carousel->save(false)) {

                    return true;

                }

            }

        }

        return false;

    }

    protected function initScenario()
    {

        if ($this->carousel->id == null) {

            $this->carousel_image->scenario = 'create';

        } else {

            $this->carousel_image->scenario = 'update';

        }

    }

}
