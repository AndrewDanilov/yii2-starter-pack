<?php

use yii\db\Migration;

/**
 * Class m190717_085259_init_custompages
 */
class m190717_085259_init_custompages extends Migration
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

	    $this->createTable('page_category', [
	    	'id' => $this->primaryKey(),
		    'slug' => $this->string()->unique(),
		    'title' => $this->string(),
		    'text' => $this->text(),
		    'category_template' => $this->string(),
		    'pages_template' => $this->string(),
		    'meta_title' => $this->string(),
		    'meta_description' => $this->string(),
	    ], $tableOptions);

	    $this->createTable('page', [
		    'id' => $this->primaryKey(),
		    'category_id' => $this->integer()->notNull(),
		    'slug' => $this->string(),
		    'image' => $this->string(),
		    'title' => $this->string(),
		    'text' => $this->text(),
		    'published_at' => $this->date(),
		    'meta_title' => $this->string(),
		    'meta_description' => $this->string(),
	    ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('page');
        $this->dropTable('page_category');
    }
}
