<?php

namespace common\models\serval\file;

use Yii;
use DateTime;
use yii\web\UploadedFile;


class FileUploadRecord extends \common\models\serval\file\BaseFileRecord
{

    protected $uploaded_file;   //object yii\web\UploadedFile

    public function __construct(array $config = [])
    {

        parent::__construct($config);

    }

    public function bind($model, $property_name)
    {

        $this->uploaded_file = UploadedFile::getInstance($model, $property_name);
        $model->{$property_name} = $this->uploaded_file;

        return $this;

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

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {

            $time_stamp = (new DateTime())->getTimestamp();

            $this->file_name = md5(uniqid(mt_rand(), true));

            if ($this->to_tmp_folder === true) {

                $this->file_name .= '-' . $time_stamp;

            }

            $this->file_orign_name = $this->uploaded_file->name;
            $this->file_ext = $this->uploaded_file->extension;
            $this->file_type = $this->uploaded_file->type;
            $this->size = $this->uploaded_file->size;
            $this->upload_timestamp = $time_stamp;
            $this->upload_user = Yii::$app->user->id;

            if ($this->moveUploadedFile()) {
                return true;
            }
        }

        return false;

    }

    protected function moveUploadedFile()
    {

        return $this->uploaded_file->saveAs($this->getUploadPath() . '/' . $this->file_name . '.' . $this->file_ext);

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

}
