<?php

namespace common\models\serval\file;

use Yii;
use yii\web\UploadedFile;


class FileRecord extends yii\db\ActiveRecord
{


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

}
