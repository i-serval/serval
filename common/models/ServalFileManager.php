<?php

namespace common\models;

use Yii;
use common\models\ServalFile;
use yii\base\ErrorException;
use yii\base\Exception;


class ServalFileManager
{

    protected $serval_file;
    protected $errors = null;
    protected $uploads_folder = 'uploads';
    protected $uploaded_file;
    protected $to_tmp_folder = false;

    public function __construct( $uploaded_file, $to_tmp_folder = false ) // object yii\web\UploadedFile
    {

        $this->to_tmp_folder = $to_tmp_folder;

        $this->serval_file = new ServalFile();

        $this->serval_file->file_name = md5(uniqid(mt_rand(), true));

        if( $to_tmp_folder === true ){
            $this->serval_file->file_name .= '-' . time();
        }

        $this->serval_file->file_orign_name = $uploaded_file->baseName;
        $this->serval_file->file_ext = $uploaded_file->extension;
        $this->serval_file->file_type = $uploaded_file->type;
        $this->serval_file->size = $uploaded_file->size;
        //$this->serval_file->size = 'sfsg';

        $this->serval_file->upload_date = date('Y-m-d');
        $this->serval_file->upload_user = Yii::$app->user->id;

        $this->uploaded_file = $uploaded_file;

        $this->upload( $to_tmp_folder );

    }

    public function upload( $to_tmp_folder = false  )
    {

        if( $this->serval_file->validate() ) {

            $this->serval_file->save();

        }else{

            $this->errors = $this->serval_file->errors;
            return $this;

        }

        if( $this->moveUploadedFile( $to_tmp_folder ) !== true ) {

            $this->serval_file->delete();

        }

        return $this;
    }

    public function getImageId()
    {
        return $this->serval_file->id;
    }
    
    protected function moveUploadedFile( $to_tmp_folder = false )
    {

        try {

            $this->uploaded_file->saveAs( $this->getUploadPath( $to_tmp_folder ) . '/' . $this->serval_file->file_name . '.' . $this->serval_file->file_ext );
            return true;

        } catch (  ErrorException $e ) {

            $this->errors[] = $e->getMessage();
            Yii::error( $e->getMessage() );

        }

        return false;

    }

    protected function getUploadPath( $to_tmp_folder = false  )
    {

        $path_parts = explode('.', number_format($this->serval_file->id / 1000, 4, '.', ''));

        $path = '';

        if ( $to_tmp_folder === true ) {

            $path = $this->uploads_folder . '/tmp';

        } else {

            $path = $this->uploads_folder . '/' . $path_parts['0'] . '/' . substr($path_parts['1'], 0, 1);

        }

        if( ! file_exists( $path ) ) {

            mkdir( $path, 0777, $recursive = true );
            //mkdir( $path, 0756, $recursive = true );

        }

        return $path;

    }

    public function destroy()
    {
        $this->serval_file->delete();

        $file_path = $this->getUploadPath( $this->to_tmp_folder ) . '/' . $this->serval_file->file_name . '.' . $this->serval_file->file_ext;

        if( file_exists( $file_path ) ) {

            unlink( $file_path );

        }
    }

    public function hasErrors()
    {
        if( count( $this->errors ) > 0 ) {
            return true;
        }
        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

}
