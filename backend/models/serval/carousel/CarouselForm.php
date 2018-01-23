<?php

namespace backend\models\serval\carousel;

use Yii;
use yii\base\Model;
use common\models\serval\carousel\CarouselRecord;


class CarouselForm extends Model
{

    public $id;
    public $title;
    public $description;
    public $activate_at;
    public $is_active;

    public function __construct(array $config = [])
    {

        parent::__construct($config);

    }

    public function rules()
    {
        return [
            [['title', 'description'], 'string', 'max' => 255],
            [['title'], 'required'],
            [['activate_at',], 'datetime', 'format' => 'php:d-m-Y H:i:s'],
            [['is_active',], 'in', 'range' => [0, 1]],
        ];
    }


    public function attributeLabels()
    {
        return [
            'title' => Yii::t('carousel', 'Title'),
            'description' => Yii::t('carousel', 'Description'),
            'activate_at' => Yii::t('carousel', 'Time of activation'),
            'is_active' => Yii::t('carousel', 'is Active'),
        ];
    }

    public function save()
    {

        if (!$this->validate()) {
            return null;
        }

        $carousel = new CarouselRecord();
        $carousel->title = $this->title;
        $carousel->description = $this->description;
        $carousel->activate_at = $this->activate_at;
        $carousel->is_active = $this->is_active;

        if ($carousel->prepareBeforeSave()->save(false)) {

            return $carousel;
        }

        if ($carousel->hasErrors()) {

            $this->addErrors($carousel->getErrors());

        }

        return null;

    }

    public function update($carousel)
    {

        if (!$this->validate()) {

            return null;
        }

        $carousel->title = $this->title;
        $carousel->description = $this->description;
        $carousel->activate_at = $this->activate_at;
        $carousel->is_active = $this->is_active;

        if ($carousel->prepareBeforeSave()->save(false)) {

            $carousel->tryDeactivatePrevCarousel();

            return $carousel;
        }

        if ($carousel->hasErrors()) {

            $this->addErrors($carousel->getErrors());

        }

        return null;

    }



    public function isNewRecord()
    {
        if ($this->id === null) {
            return true;
        }

        return false;
    }


}
