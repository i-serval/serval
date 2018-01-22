<?php

namespace common\models\serval\file;

use Yii;
use yii\web\UploadedFile;


class FileUpload extends yii\base\Model
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
    public $file;                       // input name for validation rules, object yii\web\UploadedFile

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

            $this->setScenario('create');
            return $this->insert();

        }

        $this->setScenario('update');
        return $this->update();

    }

    public function loadByID($id)
    {

        $query_cmd = Yii::$app->db->createCommand("SELECT * FROM file WHERE id=:id ")->bindValue(':id', $id);
        $result = $query_cmd->queryOne();

        $this->id = $result['id'];
        $this->file_name = $result['file_name'];
        $this->file_orign_name = $result['file_orign_name'];
        $this->file_ext = $result['file_ext'];
        $this->file_type = $result['file_type'];
        $this->size = $result['size'];
        $this->upload_timestamp = $result['upload_timestamp'];
        $this->upload_user = $result['upload_user'];

        return $this;

    }

    protected function insert()
    {

        $this->file = UploadedFile::getInstance($this, 'file');

        if ($this->validate()) {

            if ($this->file === null) {
                return true;                        // skip file if it not requaired in validation rules
            }

            $this->file_name = md5(uniqid(mt_rand(), true));

            if ($this->to_tmp_folder === true) {
                $this->file_name .= '-' . time();
            }

            $this->file_orign_name = $this->file->name;
            $this->file_ext = $this->file->extension;
            $this->file_type = $this->file->type;
            $this->size = $this->file->size;
            $this->upload_timestamp = time();
            $this->upload_user = Yii::$app->user->id;

            $this->executeInsertion();

            if ($this->moveUploadedFile() !== true) {

                $this->delete();
                return false;

            }

            return true;

        }

        return false;

    }

    protected function update()
    {

        $this->file = UploadedFile::getInstance($this, 'file');

        if ( $this->file != null && $this->validate()) {

            if ($this->file === null) {
                return true;                        // skip file if it not requaired in validation rules
            }

            $this->delete();

            $this->file_name = md5(uniqid(mt_rand(), true));

            if ($this->to_tmp_folder === true) {
                $this->file_name .= '-' . time();
            }

            $this->file_orign_name = $this->file->name;
            $this->file_ext = $this->file->extension;
            $this->file_type = $this->file->type;
            $this->size = $this->file->size;
            $this->upload_timestamp = time();
            $this->upload_user = Yii::$app->user->id;

            $this->executeUpdate();

            if ($this->moveUploadedFile() !== true) {

                $this->delete();
                return false;

            }

            return true;

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

    protected function executeUpdate()
    {
        $this->executeInsertion();
    }

    public function delete()
    {

        if ($this->id != null) {
            Yii::$app->db->createCommand("DELETE FROM file WHERE id=:id")
                ->bindValue(':id', $this->id)
                ->execute();
        }

        $file_path = $this->getUploadPath() . '/' . $this->file_name . '.' . $this->file_ext;

        if ( file_exists($file_path) && is_file( $file_path)) {

            unlink($file_path);

        }

    }

    protected function moveUploadedFile()
    {

        try {

            $this->file->saveAs($this->getUploadPath() . '/' . $this->file_name . '.' . $this->file_ext);
            return true;

        } catch (ErrorException $e) {

            $this->errors[] = $e->getMessage();
            Yii::error($e->getMessage());

        }

        return false;

    }

    protected function getUploadPath()
    {

        $path = $this->getFilePath();

        if (!file_exists($path)) {

            mkdir($path, 0777, $recursive = true);
            //mkdir( $path, 0756, $recursive = true );

        }

        return $path;

    }

    protected function getFilePath()
    {

        if ($this->to_tmp_folder === true) {

            return $this->uploads_folder . '/tmp';

        } else {

            $path_parts = explode('.', number_format($this->id / 1000, 4, '.', ''));
            return $this->uploads_folder . '/' . $path_parts['0'] . '/' . substr($path_parts['1'], 0, 1);

        }

    }

    public function getFileOrignName()
    {
        return $this->file_orign_name;
    }

    public function getFileName()
    {
        return $this->file_name;
    }

    public function getFileExtension()
    {
        return $this->file_ext;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFileUrl()
    {

        if( $this->id != null ) {

            return '/' . $this->getFilePath() . '/' . $this->getFileName() . '.' . $this->getFileExtension();

        } else {

            return null;
        }

    }

}



