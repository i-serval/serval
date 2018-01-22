<?php

namespace common\models\serval\file;

use Yii;
use yii\web\UploadedFile;


class FileUploadRecord extends yii\db\ActiveRecord
{

    protected $uploads_folder = 'uploads';
    protected $to_tmp_folder = false;

    public $file;   // input name for validation rules, object yii\web\UploadedFile

    public static function tableName()
    {
        return '{{%file}}';
    }

    public function rules()
    {
        return [
            [['size', 'upload_user', 'upload_date'], 'integer'],
            [['file_name', 'file_orign_name'], 'string', 'max' => 255],
            [['file_ext'], 'string', 'max' => 10],
            [['file_type'], 'string', 'max' => 25],
        ];
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
            'category' => 'Category',
            'upload_date' => 'Upload Date',
            'upload_user' => 'Upload User',
        ];
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

        if ($this->id != null) {

            return '/' . $this->getFilePath() . '/' . $this->getFileName() . '.' . $this->getFileExtension();

        } else {

            return null;
        }

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

    protected function moveUploadedFile()
    {

        return $this->file->saveAs($this->getUploadPath() . '/' . $this->file_name . '.' . $this->file_ext);

    }

    public function validate($attributeNames = null, $clearErrors = true)
    {

        $this->file = UploadedFile::getInstance($this, 'file');

        return parent::validate($attributeNames, $clearErrors);

    }

    public function save($runValidation = true, $attributeNames = null)
    {

        if ($runValidation === false && $this->file === null) {
            $this->file = UploadedFile::getInstance($this, 'file');
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

        if (parent::save($runValidation, $attributeNames)) {

            if ($this->moveUploadedFile()) {

                return true;

            }

            $this->delete();

        }

        return false;

    }

    public function delete()
    {

        $file_path = $this->getUploadPath() . '/' . $this->file_name . '.' . $this->file_ext;

        if (file_exists($file_path) && is_file($file_path)) {

            unlink($file_path);

        }

        parent::delete();

    }

}
