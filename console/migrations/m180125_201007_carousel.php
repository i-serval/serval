<?php

use yii\db\Migration;
use yii\db\Schema;

class m180125_201007_carousel extends Migration
{
    public function safeUp()
    {

        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {

            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        }

        $this->createTable('{{%carousel}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->string(),
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'activate_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'is_active' => "ENUM('yes','no') NOT NULL DEFAULT 'no' ",
        ], $tableOptions);

        $this->createTable('{{%carousel_item}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->string(),
            'image_id' => $this->integer(),
        ], $tableOptions);

        $this->createTable('{{%carousel_carousel_item}}', [
            'id' => $this->primaryKey(),
            'carousel_id' => $this->integer(),
            'order' => $this->Integer(),
            'carousel_item_id' => $this->integer(),
        ], $tableOptions);

    }

    public function safeDown()
    {

        $this->dropTable('{{%carousel}}');
        $this->dropTable('{{%carousel_item}}');
        $this->dropTable('{{%carousel_carousel_item}}');

    }

}
