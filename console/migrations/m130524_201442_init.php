<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
             $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
	        'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
	        'email_confirmed' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'online_at' => $this->dateTime(),
            'is_admin' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
	        'notify_on' => $this->tinyInteger(1)->unsigned()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->insert('{{%user}}', [
        	'name' => 'admin',
        	'email' => 'admin@example.com',
        	'auth_key' => Yii::$app->security->generateRandomString(),
        	'password_hash' => Yii::$app->security->generatePasswordHash('admin'),
	        'status' => 1,
	        'created_at' => date('Y-m-d H:i:s'),
	        'is_admin' => 1,
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
