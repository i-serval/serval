<?php

use yii\db\Migration;

/**
 * Class m180122_180814_carousel
 */
class m180122_180814_carousel extends Migration
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
            'created' => $this->integer(),
            'updated' => $this->integer(),
            'activate_at' => $this->integer(),
            'is_active' => $this->integer(),
        ], $tableOptions );

    }

    public function down()
    {

        return $this->dropTable('{{%carousel}}');

    }

}
