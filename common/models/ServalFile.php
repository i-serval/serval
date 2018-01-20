<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property string $file_name
 * @property string $file_orign_name
 * @property string $file_ext
 * @property string $file_type
 * @property integer $size
 * @property string $upload_date
 * @property integer $upload_user
 */

class ServalFile extends \yii\db\ActiveRecord
{
    protected $uploads_folder = 'uploads';

    public static function tableName()
    {
        return 'file';
    }

    public function rules()
    {
        return [
            [['size', 'upload_user'], 'integer'],
            [['upload_date'], 'safe'],
            [['file_name', 'file_orign_name'], 'string', 'max' => 255],
            [['file_ext'], 'string', 'max' => 10],
            [['file_type'], 'string', 'max' => 25],
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

}
