<?php

use yii\db\Migration;

/**
 * Class m181113_150913_site_setting
 */
class m181113_150913_site_setting extends Migration
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

	    // Категория
	    $this->createTable('site_setting_category', [
		    'id' => $this->primaryKey(),
		    'name' => $this->string()->notNull(),
		    'order' => $this->smallInteger()->notNull()->defaultValue(0),
	    ], $tableOptions);

	    // Настройка
	    $this->createTable('site_setting', [
		    'id' => $this->primaryKey(),
		    'category_id' => $this->integer()->notNull(),
		    'key' => $this->string()->notNull(),
		    'name' => $this->string()->notNull(),
		    'type' => $this->string(10)->notNull(),
	    ], $tableOptions);

	    // Настройка - индекс
	    $this->createIndex(
		    'idx-site_setting-category_id',
		    'site_setting',
		    'category_id'
	    );

	    // Настройка - уникальный индекс
	    $this->createIndex(
		    'ux-site_setting-key',
		    'site_setting',
		    'key',
		    true
	    );

	    // Настройка лэнг
	    $this->createTable('site_setting_lang', [
		    'id' => $this->primaryKey(),
		    'setting_id' => $this->integer()->notNull(),
		    'lang_id' => $this->integer()->notNull(),
		    'value' => $this->text(),
	    ], $tableOptions);

	    // Настройка лэнг - уникальный индекс
	    $this->createIndex(
		    'ux-site_setting_lang-setting_id-lang_id',
		    'site_setting_lang',
		    'setting_id, lang_id',
		    true
	    );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181113_150913_site_setting cannot be reverted.\n";

        return false;
    }
}
