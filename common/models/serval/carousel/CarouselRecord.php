<?php

namespace common\models\serval\carousel;

use Yii;
use \DateTime;
use \backend\models\serval\carousel\CarouselManager;
use \common\models\serval\carousel\CarouselItemRecord;


class CarouselRecord extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%carousel}}';
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
            'activate_at' => 'Time of activation',
            'is_active' => 'Is Active',
        ];
    }

    public function getCarouselItems()
    {
        return $this->hasMany(CarouselItemRecord::className(), ['id' => 'carousel_item_id'])
            ->viaTable('carousel_carousel_item', ['carousel_id' => 'id']);
    }


    public function beforeSave($insert)
    {

        if ($this->beforeSaveChecks($insert)) {

            if (parent::beforeSave($insert)) {

                return true;

            }

        }

        return false;

    }

    public function tryDeactivatePrevCarousel()
    {

        //TODO: NOT WORK !!!!!!!!!!!
        if (($prev_active_carousel = self::find()->Where(['<>', 'id', $this->id])->andWhere(['is_active' => 1])->one()) !== null) {

            $prev_active_carousel->is_active = 0;
            $prev_active_carousel->save();

        }

    }

    protected function beforeSaveChecks($insert)
    {

        if ($this->activate_at != '') {

            if ($this->activate_at < (new DateTime())->getTimestamp()) {

                $this->addError('activate_at', Yii::t('carousel', 'Carousel activation time set in past'));

                return false;

            }
        }

        if ($this->getOldAttribute('is_active') == 0 && $this->is_active == 1) {

            if (count($this->carouselItems) < 1) {

                $this->addError('is_active', Yii::t('carousel', 'For activation carousel must have at least one picture'));

                return false;

            }

        }

        if ($this->getOldAttribute('is_active') == 1 && $this->is_active == 0) {


            $this->addError('is_active', Yii::t('carousel', 'You cannot deactivate the slider, just activate the other one and this is automatically deactivated'));

            return false;

        }


        return true;

    }

    public function prepareBeforeSave()
    {

        if ($this->activate_at != '') {

            $this->activate_at = (new DateTime($this->activate_at))->getTimestamp();

        }

        $date = new DateTime();
        $this->updated = $date->getTimestamp();

        if ($this->id === null) {

            $this->created = $date->getTimestamp();

        }

        return $this;

    }

}
