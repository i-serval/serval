<?php

use yii\db\Migration;

/**
 * Class m180122_180859_carousel_carousel_item
 */
class m180122_180859_carousel_carousel_item extends Migration
{
    public function up()
    {

        $tableOptions = null;

        if ( $this->db->driverName === 'mysql' ) {

            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        }

        $this->createTable('{{%carousel_carousel_item}}', [
            'id' => $this->primaryKey(),
            'carousel_id' => $this->integer(),
            'carousel_item_id' => $this->integer(),
        ], $tableOptions );

        $this->createIndex(
            'carousel_item_id',
            'carousel_carousel_item',
            'carousel_item_id'
        );
        $this->createIndex(
            'carousel_id',
            'carousel_carousel_item',
            'carousel_id'
        );

    }

    public function down()
    {

        return $this->dropTable('{{%carousel_carousel_item}}');

    }
}
