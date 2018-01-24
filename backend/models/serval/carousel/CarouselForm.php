<?php

namespace backend\models\serval\carousel;

use Yii;
use DateTime;
use yii\base\Model;
use common\models\serval\carousel\CarouselRecord;
use backend\models\serval\carousel\CarouselManager;


class CarouselForm extends Model
{
    public $id;
    public $title;
    public $description;
    public $activate_at;
    public $is_active;

    protected $carousel_instance;

    public function __construct(array $config = [])
    {

        parent::__construct($config);

    }

    public function rules()
    {
        return [
            [['title', 'description'], 'string', 'max' => 255],
            ['title', 'required'],
            ['activate_at', 'datetime', 'format' => 'php:d-m-Y H:i:s'],
            ['activate_at', 'validateActivationTime'],
            ['is_active', 'in', 'range' => [0, 1]],
            ['is_active', 'default', 'value' => 0],
            ['is_active', 'validateIsActive', 'on' => 'update'],
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
        $carousel->is_active = $this->is_active;
        $carousel->created = (new DateTime())->getTimestamp();
        $carousel->updated = $carousel->created;

        if ($this->activate_at != '') {

            $carousel->activate_at = (new DateTime($this->activate_at))->getTimestamp();

        }

        return $carousel->save() ? $carousel : null;

    }

    public function update($carousel)
    {
        $this->scenario = 'update';

        $this->carousel_instance = clone $carousel;

        if (!$this->validate()) {

            return null;
        }

        $carousel->title = $this->title;
        $carousel->description = $this->description;
        $carousel->activate_at = $this->activate_at;
        $carousel->is_active = $this->is_active;
        $carousel->updated = (new DateTime())->getTimestamp();

        if ($this->activate_at != '') {

            $carousel->activate_at = (new DateTime($this->activate_at))->getTimestamp();

        }

        if ($carousel->save()) {


            if ($this->carousel_instance->is_active != $this->is_active && $this->is_active == 1) {

                (new CarouselManager())->tryDeactivateAllExeptCurrent($carousel);

            }

            return $carousel;

        } else {

            return null;
        }

    }

    public function validateActivationTime($attribute, $params)
    {

        if ($this->activate_at != '') {

            if ($this->scenario == 'update') {

                if ($this->carousel_instance->activate_at === (new DateTime($this->activate_at))->getTimestamp()) {
                    return;
                }

            }

            if ((new DateTime($this->activate_at))->getTimestamp() < (new DateTime())->getTimestamp()) {

                $this->addError('activate_at', Yii::t('carousel', 'Carousel activation time set in past'));

            }
        }

    }

    public function validateIsActive($attribute, $params)
    {

        if ($this->carousel_instance->is_active == 0 && $this->is_active == 1) {

            if (count($this->carousel_instance->carouselItems) < 1) {

                $this->addError('is_active', Yii::t('carousel', 'For activation slider must have at least one image'));

            }

        }

        if ($this->carousel_instance->is_active == 1 && $this->is_active == 0) {

            $this->addError('is_active', Yii::t('carousel', 'You cannot deactivate the slider, just activate the other one and this is automatically deactivated'));

        }

    }

    public function isNewRecord()
    {
        if ($this->id === null) {
            return true;
        }

        return false;
    }

}
