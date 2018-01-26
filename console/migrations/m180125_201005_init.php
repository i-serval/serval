<?php

use yii\db\Migration;
use yii\db\Schema;
use common\models\serval\user\UserIdentityRecord;


class m180125_201005_init extends Migration
{

    const ADMIN_USERNAME_ONE = 'admin';
    const ADMIN_EMAIL_ONE = 'admin@admin.com';
    const ADMIN_PASSWORD_ONE = '123456';
    const ADMIN_USERNAME_TWO = 'test';
    const ADMIN_EMAIL_TWO = 't@t.t';
    const ADMIN_PASSWORD_TWO = '123456';

    public function safeUp()
    {

        $date = new DateTime();

        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => Schema::TYPE_DATETIME . ' NOT NULL',
            'updated_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
            'login_at' => Schema::TYPE_DATETIME . ' NULL DEFAULT NULL',
        ], $tableOptions);

        $this->batchInsert('{{%user}}', [
            'id',
            'name',
            'auth_key',
            'password_hash',
            'email',
            'status',
            'created_at',
            'updated_at'
        ], [
            [
                1,
                self::ADMIN_USERNAME_ONE,
                Yii::$app->security->generateRandomString(),
                Yii::$app->security->generatePasswordHash(self::ADMIN_PASSWORD_ONE),
                self::ADMIN_EMAIL_ONE,
                UserIdentityRecord::STATUS_ACTIVE,
                $date->format('Y-m-d H:i:s'),
                $date->format('Y-m-d H:i:s')
            ],
            [
                2,
                self::ADMIN_USERNAME_TWO,
                Yii::$app->security->generateRandomString(),
                Yii::$app->security->generatePasswordHash(self::ADMIN_PASSWORD_TWO),
                self::ADMIN_EMAIL_TWO,
                UserIdentityRecord::STATUS_ACTIVE,
                $date->format('Y-m-d H:i:s'),
                $date->format('Y-m-d H:i:s')
            ]
        ]);

    }

    public function safeDown()
    {

        $this->dropTable('{{%user}}');

    }
}
