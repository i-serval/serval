<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\Carousel;
use common\models\ServalFileManager;
use common\models\ServalFile;
use yii\web\UploadedFile;


class CarouselForm extends Model
{
    public $id;
    public $carousel_id;
    public $title;
    public $description;
    public $order;

    public $image_file;
    public $image_id;

    public function rules()
    {
        return [
            [
                ['image_file'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'minWidth' => 1125, 'maxWidth' => 1125, 'minHeight' => 600, 'maxHeight' => 600, 'on' => 'create'
            ],
            [
                ['image_file'], 'image', 'extensions' => 'png, jpg', 'minWidth' => 1125, 'maxWidth' => 1125, 'minHeight' => 600, 'maxHeight' => 600, 'on' => 'update'
            ],
            [
                ['title', 'description'], 'string', 'max' => 255
            ],
            [
                ['title', 'description', 'order'], 'required'
            ],
            [
                ['order'], 'number'
            ],
        ];
    }

    public function save()
    {

        

        $this->image_file = UploadedFile::getInstance( $this, 'image_file' );

        if ( $this->validate() ) {

            $file_manager = new ServalFileManager( $this->image_file );
            $file_manager->upload();

            if( $file_manager->hasErrors() ) {

                $file_manager->destroy();
                $this->errors['image_file'] = $file_manager->getErrors();
                return false;

            }

            $carousel = new Carousel();

            $carousel->setAttributes( $this->getAttributes() ); //set data from current form to carousel model

            $carousel->image_id =  $file_manager->getImageId();

            if ( $carousel->save() ) {
                
                $this->carousel_id = $carousel->id;

                return true;

            }

            return false;

        }

        return false;

    }

    public function update()
    {

        $this->image_file = UploadedFile::getInstance( $this, 'image_file' );

        if ( $this->validate() ) {

            if( $this->image_file !== null ) {


                $file_manager = new ServalFileManager( $this->image_file );
                $file_manager->upload();

                if ( $file_manager->hasErrors() ) {

                    $file_manager->destroy();
                    $this->errors['image_file'] = $file_manager->getErrors();
                    return false;

                }

            }

            $carousel = Carousel::findOne( $this->id );

            if( $this->image_file !== null ) {

                $serval_file = ServalFile::findOne($carousel->image_id); // delete prev image if new uploaded

                if( $serval_file != null ) {

                    $serval_file->delete();

                }

            }

            $carousel->setAttributes( $this->getAttributes() ); //set data from current form to carousel model

            if( $this->image_file !== null ) {

                $carousel->image_id = $file_manager->getImageId();

            }

            if ( $carousel->save() ) {

                $this->carousel_id = $carousel->id;

                return true;

            }

            return false;

        }

        return false;

    }


    public function isNewRecord()
    {
        if ($this->id === null) {
            return true;
        }

        return false;
    }

}