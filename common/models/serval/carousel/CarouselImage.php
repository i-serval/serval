<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\ServalFileManager;
use yii\web\UploadedFile;

class CarouselImage extends Model
{
    protected $uploads_folder = 'uploads';

    public $id;
    public $file;

    public static function tableName()
    {
        return 'file';
    }

    public function rules()
    {
        return [
            [
                //['file'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'minWidth' => 1125, 'maxWidth' => 1125, 'minHeight' => 600, 'maxHeight' => 600, 'on' => 'create'
                ['file'], 'image', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'minWidth' => 1125, 'maxWidth' => 1125, 'minHeight' => 600, 'maxHeight' => 600,
            ]
        ];
    }

    public function getImageUrl()
    {

        $path_parts = explode( '.',  number_format( $this->id/1000, 4, '.', '' ) );

        $path = $this->uploads_folder . '/' . $path_parts[ '0' ] . '/' . substr( $path_parts[ '1' ], 0, 1 ) . '/' . $this->file_name . '.' . $this->file_ext;

        if( file_exists( $path ) ) {

            return '/' . $path;

        }

        return 'no file on path:' . $path;

    }

    public function getImageTmpUrl()
    {


        $path = $this->uploads_folder . '/tmp/' . $this->file_name . '.' . $this->file_ext;

        if( file_exists( $path ) ) {

            return '/' . $path;

        }

        return 'no file on path:' . $path;

    }

    public function getCanonicalPath()
    {

        $path_parts = explode( '.',  number_format( $this->id/1000, 4, '.', '' ) );

        $path = $this->uploads_folder . '/' . $path_parts[ '0' ] . '/' . substr( $path_parts[ '1' ], 0, 1 );

        if( ! file_exists( $path ) ) {

            mkdir( $path, 0777, $recursive = true );
            //mkdir( $path, 0756, $recursive = true );

        }

        return $path;

    }

    public function getImageOrignName()
    {
        return $this->file_orign_name . '.' . $this->file_ext;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'file_name' => 'File Name',
            'file_orign_name' => 'File Orign Name',
            'file_ext' => 'File Ext',
            'file_type' => 'File Type',
            'size' => 'Size',
            'upload_date' => 'Upload Date',
            'upload_user' => 'Upload User',
        ];
    }

    public function delete()
    {

        $path_parts = explode( '.',  number_format( $this->id/1000, 4, '.', '' ) );

        $path = $this->uploads_folder . '/' . $path_parts[ '0' ] . '/' . substr( $path_parts[ '1' ], 0, 1 );


        $file_path = $path . '/' . $this->file_name . '.' . $this->file_ext;

        if( file_exists( $file_path ) ) {

            unlink( $file_path );

        }

        parent::delete();

    }

    /*--------------------------------------------------*/


    public function isNewRecord(){

        if( $this->id == null ) {
            return true;
        }

        return false;

    }

    public function save(){

        if( $this->isNewRecord() ){
            return $this->insert();
        }

        return $this->update();

    }

    protected function insert()
    {


        $this->file = UploadedFile::getInstance($this, 'file');

        if( $this->validate() ) {


            $file_manager = new ServalFileManager($this->file);
            $file_manager->upload();

            if ($file_manager->hasErrors()) {

                $file_manager->destroy();
                $this->errors['file'] = $file_manager->getErrors();

                return false;

            }

            $this->id = $file_manager->getImageId();

            return true;
        }

        return false;

    }

}
