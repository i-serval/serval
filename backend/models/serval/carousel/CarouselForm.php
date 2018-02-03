<?php

namespace backend\models\serval\carousel;

use Yii;
use DateTime;
use yii\base\Model;
use common\models\serval\carousel\CarouselRecord;
use backend\models\serval\carousel\CarouselManager;
use common\models\serval\helper\DateTimeHelper;


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
            ['activate_at', 'datetime', 'format' => DateTimeHelper::modifyFormat(Yii::$app->formatter->datetimeFormat, [':s' => ''])],  // validate date&time without seconds
            ['activate_at', 'validateActivationTime'],
            ['is_active', 'in', 'range' => ['no', 'yes']],
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
        $carousel->setTitle($this->title)
            ->setDescription($this->description)
            ->setCreatedAt(new DateTime())
            ->setUpdatedAt($carousel->created_at)
            ->setIsActive($this->is_active)
            ->setActivateAt($this->activate_at);

        return $carousel->save() ? $carousel : null;

    }

    public function update($carousel)
    {
        $this->scenario = 'update';

        $this->carousel_instance = clone $carousel;

        if (!$this->validate()) {

            return null;
        }

        $carousel->setTitle($this->title)
            ->setDescription($this->description)
            ->setUpdatedAt(new DateTime())
            ->setIsActive($this->is_active)
            ->setActivateAt($this->activate_at);

        if ($carousel->save()) {

            if ($this->carousel_instance->is_active != $this->is_active && $this->is_active == 'yes') {

                (new CarouselManager())->tryDeactivateAllExeptCurrent($carousel->id)
                    ->setNullForExpiredActivationTime();

                $carousel->activate_at = null;
                $carousel->last_activation_at = DateTimeHelper::getCurrentMysqlTimestamp();
                $carousel->save();

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

                if (DateTimeHelper::comapre($this->carousel_instance->activate_at, $this->activate_at) === 0) {   // -1 0 1 like spaceship <=>
                    return;
                }

            }

            if (DateTimeHelper::comapre($this->activate_at, new DateTime()) === -1) { // -1 0 1 like spaceship <=>

                $this->addError('activate_at', Yii::t('carousel', 'Carousel activation time set in past'));

            }
        }

    }

    public function validateIsActive($attribute, $params)
    {

        if ($this->carousel_instance->is_active == 'no' && $this->is_active == 'yes') {

            if (count($this->carousel_instance->carousel_items) < 1) {

                $this->addError('is_active', Yii::t('carousel', 'For activation slider must have at least one slide image'));

            }

        }

        if ($this->carousel_instance->is_active == 'no' && $this->is_active == 'yes') {

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
