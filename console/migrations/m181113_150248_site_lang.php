<?php

use yii\db\Migration;

/**
 * Class m181113_150248_lang
 */
class m181113_150248_site_lang extends Migration
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

	    // Язык
	    $this->createTable('site_lang', [
		    'id' => $this->primaryKey(),
		    'key' => $this->string()->notNull(),
		    'is_default' => $this->tinyInteger(1)->notNull()->defaultValue(0),
		    'name' => $this->string()->notNull(),
		    'image' => $this->string(),
		    'currency' => $this->string(),
		    'currency_value' => $this->decimal(12, 6)->notNull()->defaultValue(1),
	    ], $tableOptions);

	    // Язык - уникальный индекс
	    $this->createIndex(
		    'ux-site_lang-key',
		    'site_lang',
		    'key',
		    true
	    );

	    // Дефолтные данные
	    $this->insert('site_lang', [
		    'key' => 'ru',
		    'is_default' => 1,
		    'name' => 'Русский',
		    'currency' => 'руб.',
		    'currency_value' => 1,
	    ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181113_150248_lang cannot be reverted.\n";

        return false;
    }
}
