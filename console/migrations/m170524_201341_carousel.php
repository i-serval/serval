<?php

use yii\db\Migration;


class m170524_201341_carousel extends Migration
{
    public function up()
    {

        $tableOptions = null;

        if ( $this->db->driverName === 'mysql' ) {

            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        }

        $this->createTable('{{%carousel}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->string(),
            'order' => $this->smallInteger(),
            'image_id' => $this->integer(),
        ], $tableOptions );

    }

    public function down()
    {
        $this->dropTable('{{%carousel}}');
    }
}
