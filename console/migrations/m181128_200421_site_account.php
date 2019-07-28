<?php

use yii\db\Migration;

/**
 * Class m181128_200421_site_account
 */
class m181128_200421_site_account extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	    $tableOptions = null;
	    if ($this->db->driverName === 'mysql') {
		    $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
	    }

	    // Аккаунт
	    $this->createTable('site_account', [
		    'id' => $this->primaryKey(),
		    'user_id' => $this->integer()->notNull(),
		    'name' => $this->string(),
		    'phone' => $this->string(),
		    'organization' => $this->string(),
		    'inn' => $this->string(),
	    ], $tableOptions);

	    // Аккаунт - уникальный индекс
	    $this->createIndex(
		    'ux-site_account-user_id',
		    'site_account',
		    'user_id',
		    true
	    );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181128_200421_site_account cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181128_200421_site_account cannot be reverted.\n";

        return false;
    }
    */
}
