<?php

namespace common\models\serval\file;

use Yii;
use DateTime;
use yii\web\UploadedFile;
use common\models\serval\helper\DateTimeHelper;

class FileUploadRecord extends \common\models\serval\file\BaseFileRecord
{

    protected $uploaded_file;   //object yii\web\UploadedFile

    public function __construct(array $config = [])
    {

        parent::__construct($config);

    }

    public function initFrom($model)
    {

        $this->setAttributes($model->getAttributes());
        $this->id = $model->id;

        $this->isNewRecord = false; // because need update instead of insert

        return $this;

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

        $path_to_old_file = '';

        if(  !$insert ){
            $path_to_old_file = $this->getFilePath() . '/' . $this->name . '.' . $this->ext;
        }

        if (parent::beforeSave($insert)) {

            if ($this->uploaded_file == null) {
                return false;
            }

            $this->name = md5(uniqid(mt_rand(), true));

            if ($this->to_tmp_folder === true) {

                $this->name .= '-' . DateTimeHelper::getCurrentMysqlTimestamp();

            }

            $this->original_name = $this->uploaded_file->name;
            $this->ext = $this->uploaded_file->extension;
            $this->type = $this->uploaded_file->type;
            $this->size = $this->uploaded_file->size;
            $this->upload_time = DateTimeHelper::getCurrentMysqlTimestamp();
            $this->upload_user = Yii::$app->user->id;

            if ($this->moveUploadedFile()) {
                if( !$insert ){ // if update delet prev file in disk
                    $this->deleteFileInDisk($path_to_old_file);
                }
                return true;
            }
        }

        return false;

    }

    protected function moveUploadedFile()
    {

        return $this->uploaded_file->saveAs($this->getUploadPath() . '/' . $this->name . '.' . $this->ext);

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
