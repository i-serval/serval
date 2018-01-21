<?php

use yii\db\Migration;

class m170524_212914_file extends Migration
{
    public function up()
    {

        $tableOptions = null;

        if ( $this->db->driverName === 'mysql' ) {

            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        }

        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string(255),
            'file_orign_name' => $this->string(255),
            'file_ext' => $this->string(10),
            'file_type' => $this->string(25),
            'size' => $this->Integer(),
            'category' => $this->string(255),
            'upload_timestamp' => $this->integer(),
            'upload_user' => $this->integer(),
        ], $tableOptions );

    }

    public function down()
    {
        $this->dropTable('{{%file}}');
    }

}















