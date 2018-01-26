<?php

use yii\db\Migration;
use yii\db\Schema;

class m180125_201006_file extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {

            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        }

        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'original_name' => $this->string(255),
            'ext' => $this->string(10),
            'type' => $this->string(25),
            'size' => $this->Integer(),
            'category' => $this->string(255),
            'upload_time' => Schema::TYPE_DATETIME . ' NOT NULL',
            'upload_user' => $this->integer(),
        ], $tableOptions);

    }

    public function safeDown()
    {
        $this->dropTable('{{%file}}');
    }

}
