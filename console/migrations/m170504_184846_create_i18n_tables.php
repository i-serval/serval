<?php

use yii\db\Migration;

class m170504_184846_create_i18n_tables extends Migration
{
    public function up()
    {

        $this->execute(
            file_get_contents(
                Yii::getAlias( '@yii/i18n/migrations/schema-mysql.sql' )
            )
        );

        //./yii migrate --migrationPath='@yii/i18n/migrations'

    }

    public function down()
    {
        echo "m170504_184845_create_rbac_tables cannot be reverted.\n";

        return false;
    }

}
