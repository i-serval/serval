<?php

use yii\db\Migration;

/**
 * Class m180122_180823_carousel_item
 */
class m180122_180823_carousel_item extends Migration
{

    public function up()
    {

        $tableOptions = null;

        if ( $this->db->driverName === 'mysql' ) {

            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        }

        $this->createTable('{{%carousel_item}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'description' => $this->string(),
            'order' => $this->smallInteger(),
            'image_id' => $this->integer(),
        ], $tableOptions );

    }

    public function down()
    {

        return $this->dropTable('{{%carousel_item}}');

    }

}
