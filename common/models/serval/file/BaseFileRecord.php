<?php

namespace common\models\serval\file;

use Yii;

// base class for files classes

class BaseFileRecord extends \yii\db\ActiveRecord
{

    protected $uploads_folder = 'uploads';
    protected $to_tmp_folder = false;

    public function __construct(array $config = [])
    {

        parent::__construct($config);

    }

    public static function tableName()
    {
        return '{{%file}}';
    }

    public function rules()
    {
        return [
            [['size', 'upload_user', 'upload_timestamp'], 'integer'],
            [['file_name', 'file_orign_name'], 'string', 'max' => 255],
            [['file_ext'], 'string', 'max' => 10],
            [['file_type'], 'string', 'max' => 25],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('serval/files', 'ID'),
            'file_name' => Yii::t('serval/files', 'File Name'),
            'file_orign_name' => Yii::t('serval/files', 'File Orign Name'),
            'file_ext' => Yii::t('serval/files', 'File Ext'),
            'file_type' => Yii::t('serval/files', 'File Type'),
            'size' => Yii::t('serval/files', 'Size'),
            'category' => Yii::t('serval/files', 'Category'),
            'upload_timestamp' => Yii::t('serval/files', 'Upload Date'),
            'upload_user' => Yii::t('serval/files', 'Upload User'),
        ];
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

    public function delete()
    {

        $file_path = $this->getFilePath() . '/' . $this->file_name . '.' . $this->file_ext;

        if (file_exists($file_path) && is_file($file_path)) {

            unlink($file_path);

        }

        parent::delete();

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

}
