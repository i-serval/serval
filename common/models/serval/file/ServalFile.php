<?php

namespace common\models\serval\files;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;


class ServalFile extends Model
{

    protected $id;
    protected $file_name;
    protected $file_orign_name;
    protected $file_ext;
    protected $file_type;
    protected $size;
    protected $category = 'default';
    protected $upload_timestamp;
    protected $upload_user;

    protected $uploads_folder = 'uploads';
    protected $to_tmp_folder = false;
    protected $uploaded_file;           //object yii\web\UploadedFile
    public $file;                       // input name for validation rules

    public function __construct(array $config = [])
    {
        parent::__construct($config);

    }

    public function setUploadFolder($folder)
    {
        $this->uploads_folder = $folder;
        return $this;
    }

    public function getUploadFolder()
    {
        return $this->uploads_folder;
    }

    public function toTmpFolder()
    {

        $this->to_tmp_folder = true;
        return $this;

    }

    public function setCategory($category)
    {

        $this->category = $category;
        return $this;

    }

    public function isNewRecord()
    {

        if ($this->id == null) {
            return true;
        }

        return false;

    }

    public function save()
    {

        if ($this->isNewRecord()) {

            return $this->insert();

        }

        return $this->update();

    }

    protected function insert()
    {

        $this->uploaded_file = UploadedFile::getInstance($this, 'file');

        if ($this->validate()) {

            $this->file_name = md5(uniqid(mt_rand(), true));

            if ($this->to_tmp_folder === true) {
                $this->file_name .= '-' . time();
            }

            $this->file_orign_name = $this->uploaded_file->baseName;
            $this->file_ext = $this->uploaded_file->extension;
            $this->file_type = $this->uploaded_file->type;
            $this->size = $this->uploaded_file->size;
            $this->upload_timestamp = time();
            $this->upload_user = Yii::$app->user->id;

            $this->executeInsertion();

            if ($this->moveUploadedFile() !== true) {

              $this->delete();

            }

        }

        return false;

    }

    protected function executeInsertion()
    {

        $insert = "INSERT INTO file ( 
          `file_name`, 
          `file_orign_name`, 
          `file_ext`, 
          `file_type`, 
          `size`, 
          `category`, 
          `upload_timestamp`, 
          `upload_user` ) 
          VALUES ( 
          :file_name, 
          :file_orign_name, 
          :file_ext, 
          :file_type, 
          :size, 
          :category, 
          :upload_timestamp, 
          :upload_user
          )";

        Yii::$app->db->createCommand($insert)
            ->bindValue(':file_name', $this->file_name)
            ->bindValue(':file_orign_name', $this->file_orign_name)
            ->bindValue(':file_ext', $this->file_ext)
            ->bindValue(':file_type', $this->file_type)
            ->bindValue(':size', $this->size)
            ->bindValue(':category', $this->category)
            ->bindValue(':upload_timestamp', $this->upload_timestamp)
            ->bindValue(':upload_user', $this->upload_user)
            ->execute();

        $this->id = Yii::$app->db->getLastInsertID();

    }

    protected function delete()
    {

        if( $this->id != null ) {
            Yii::$app->db->createCommand("DELETE FORM file WHERE id=:id")
                ->bindValue(':id', $this->id)
                ->execute();
        }

        $file_path = $this->getUploadPath( ) . '/' . $this->file_name . '.' . $this->file_ext;

        if( file_exists( $file_path ) ) {

            unlink( $file_path );

        }

    }

    protected function moveUploadedFile()
    {

        try {

            $this->uploaded_file->saveAs( $this->getUploadPath() . '/' . $this->file_name . '.' . $this->file_ext );
            return true;

        } catch (  ErrorException $e ) {

            $this->errors[] = $e->getMessage();
            Yii::error( $e->getMessage() );

        }

        return false;

    }

    protected function getUploadPath( )
    {

        $path_parts = explode('.', number_format($this->id / 1000, 4, '.', ''));

        $path = '';

        if ( $this->to_tmp_folder === true ) {

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

}
