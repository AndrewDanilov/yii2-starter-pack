<?php

use yii\db\Migration;

/**
 * Class m181113_151133_site_shop
 */
class m181113_151133_site_shop extends Migration
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
	    $this->createTable('site_shop_category', [
		    'id' => $this->primaryKey(),
		    'image' => $this->string(),
		    'order' => $this->smallInteger()->notNull()->defaultValue(0),
	    ], $tableOptions);

	    // Категория лэнг
	    $this->createTable('site_shop_category_lang', [
	    	'id' => $this->primaryKey(),
	    	'category_id' => $this->integer()->notNull(),
	    	'lang_id' => $this->integer()->notNull(),
	    	'name' => $this->string()->notNull(),
	    	'description' => $this->text(),
	    	'seo_title' => $this->string(),
	    	'seo_description' => $this->text(),
	    ], $tableOptions);

	    // Категория лэнг - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_category_lang-category_id-lang_id',
		    'site_shop_category_lang',
		    'category_id, lang_id',
		    true
	    );

	    // Бренд
	    $this->createTable('site_shop_brand', [
		    'id' => $this->primaryKey(),
		    'image' => $this->string(),
		    'is_favorite' => $this->tinyInteger(1)->notNull()->defaultValue(0),
		    'order' => $this->smallInteger()->notNull()->defaultValue(0),
	    ], $tableOptions);

	    // Бренд лэнг
	    $this->createTable('site_shop_brand_lang', [
		    'id' => $this->primaryKey(),
		    'brand_id' => $this->integer()->notNull(),
		    'lang_id' => $this->integer()->notNull(),
		    'name' => $this->string()->notNull(),
		    'description' => $this->text(),
		    'seo_title' => $this->string(),
		    'seo_description' => $this->text(),
	    ], $tableOptions);

	    // Бренд лэнг - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_brand_lang-brand_id-lang_id',
		    'site_shop_brand_lang',
		    'brand_id, lang_id',
		    true
	    );

	    // Товар
	    $this->createTable('site_shop_product', [
		    'id' => $this->primaryKey(),
		    'article' => $this->string(),
		    'brand_id' => $this->integer(),
		    'old_price' => $this->decimal(8, 0)->notNull(),
		    'price' => $this->decimal(8, 0)->notNull(),
		    'is_popular' => $this->tinyInteger(1)->notNull()->defaultValue(0),
	    ], $tableOptions);

	    // Товар - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_product-article',
		    'site_shop_product',
		    'article',
		    true
	    );

	    // Товар - индекс
	    $this->createIndex(
		    'idx-site_shop_product-brand_id',
		    'site_shop_product',
		    'brand_id'
	    );

	    // Товар - индекс
	    $this->createIndex(
		    'idx-site_shop_product-is_popular',
		    'site_shop_product',
		    'is_popular'
	    );

	    // Товар лэнг
	    $this->createTable('site_shop_product_lang', [
		    'id' => $this->primaryKey(),
		    'product_id' => $this->integer()->notNull(),
		    'lang_id' => $this->integer()->notNull(),
		    'name' => $this->string()->notNull(),
		    'description' => $this->text(),
		    'seo_title' => $this->string(),
		    'seo_description' => $this->text(),
	    ], $tableOptions);

	    // Товар лэнг - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_product_lang-product_id-lang_id',
		    'site_shop_product_lang',
		    'product_id, lang_id',
		    true
	    );

	    // Изображения товаров
	    $this->createTable('site_shop_product_images', [
		    'id' => $this->primaryKey(),
		    'product_id' => $this->integer()->notNull(),
		    'image' => $this->string()->notNull(),
		    'order' => $this->smallInteger()->notNull()->defaultValue(0),
	    ], $tableOptions);

	    // Изображения товаров - индекс
	    $this->createIndex(
		    'idx-site_shop_product_images-product_id',
		    'site_shop_product_images',
		    'product_id'
	    );

	    // Категории товаров
	    $this->createTable('site_shop_product_categories', [
		    'id' => $this->primaryKey(),
		    'product_id' => $this->integer()->notNull(),
		    'category_id' => $this->integer()->notNull(),
	    ], $tableOptions);

	    // Категории товаров - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_product_categories-product_id-category_id',
		    'site_shop_product_categories',
		    'product_id, category_id',
		    true
	    );

	    // Опция
	    $this->createTable('site_shop_option', [
		    'id' => $this->primaryKey(),
		    'order' => $this->smallInteger()->notNull()->defaultValue(0),
	    ], $tableOptions);

	    // Опция лэнг
	    $this->createTable('site_shop_option_lang', [
		    'id' => $this->primaryKey(),
		    'option_id' => $this->integer()->notNull(),
		    'lang_id' => $this->integer()->notNull(),
		    'name' => $this->string()->notNull(),
	    ], $tableOptions);

	    // Опция лэнг - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_option_lang-option_id-lang_id',
		    'site_shop_option_lang',
		    'option_id, lang_id',
		    true
	    );

	    // Опции категорий
	    $this->createTable('site_shop_category_options', [
		    'id' => $this->primaryKey(),
		    'option_id' => $this->integer()->notNull(),
		    'category_id' => $this->integer()->notNull(),
	    ], $tableOptions);

	    // Опции категорий - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_category_options-option_id-category_id',
		    'site_shop_category_options',
		    'option_id, category_id',
		    true
	    );

	    // Опции товаров
	    $this->createTable('site_shop_product_options', [
		    'id' => $this->primaryKey(),
		    'option_id' => $this->integer()->notNull(),
		    'product_id' => $this->integer()->notNull(),
		    'margin' => $this->decimal(8, 0)->notNull(),
		    'margin_type' => $this->tinyInteger(1)->notNull()->defaultValue(1),
	    ], $tableOptions);

	    // Опции товаров - индекс
	    $this->createIndex(
		    'idx-site_shop_product_options-option_id-product_id',
		    'site_shop_product_options',
		    'option_id, product_id'
	    );

	    // Опции товаров лэнг
	    $this->createTable('site_shop_product_options_lang', [
		    'id' => $this->primaryKey(),
		    'product_option_id' => $this->integer()->notNull(),
		    'lang_id' => $this->integer()->notNull(),
		    'value' => $this->string()->notNull(),
	    ], $tableOptions);

	    // Опции товаров лэнг - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_product_options_lang-product_option_id-lang_id',
		    'site_shop_product_options_lang',
		    'product_option_id, lang_id',
		    true
	    );

	    // Атрибут
	    $this->createTable('site_shop_attribute', [
		    'id' => $this->primaryKey(),
		    'type' => $this->string(10)->notNull(),
		    'order' => $this->smallInteger()->notNull()->defaultValue(0),
	    ], $tableOptions);

	    // Атрибут лэнг
	    $this->createTable('site_shop_attribute_lang', [
		    'id' => $this->primaryKey(),
		    'attribute_id' => $this->integer()->notNull(),
		    'lang_id' => $this->integer()->notNull(),
		    'name' => $this->string()->notNull(),
	    ], $tableOptions);

	    // Атрибут лэнг - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_attribute_lang-attribute_id-lang_id',
		    'site_shop_attribute_lang',
		    'attribute_id, lang_id',
		    true
	    );

	    // Атрибуты категорий
	    $this->createTable('site_shop_category_attributes', [
		    'id' => $this->primaryKey(),
		    'attribute_id' => $this->integer()->notNull(),
		    'category_id' => $this->integer()->notNull(),
	    ], $tableOptions);

	    // Атрибуты категорий - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_category_attributes-attribute_id-category_id',
		    'site_shop_category_attributes',
		    'attribute_id, category_id',
		    true
	    );

	    // Атрибуты товаров
	    $this->createTable('site_shop_product_attributes', [
		    'id' => $this->primaryKey(),
		    'attribute_id' => $this->integer()->notNull(),
		    'product_id' => $this->integer()->notNull(),
	    ], $tableOptions);

	    // Атрибуты товаров - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_product_attributes-attribute_id-product_id',
		    'site_shop_product_attributes',
		    'attribute_id, product_id',
		    true
	    );

	    // Атрибуты товаров лэнг
	    $this->createTable('site_shop_product_attributes_lang', [
		    'id' => $this->primaryKey(),
		    'product_attribute_id' => $this->integer()->notNull(),
		    'lang_id' => $this->integer()->notNull(),
		    'value' => $this->text(),
	    ], $tableOptions);

	    // Атрибуты товаров лэнг - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_product_attributes_lang-product_attr_id-lang_id',
		    'site_shop_product_attributes_lang',
		    'product_attribute_id, lang_id',
		    true
	    );

	    // Заказ
	    $this->createTable('site_shop_order', [
		    'id' => $this->primaryKey(),
		    'account_id' => $this->integer()->notNull(),
		    'created_at' => $this->dateTime(),
		    'addressee_name' => $this->string(),
		    'addressee_email' => $this->string(),
		    'addressee_phone' => $this->string(),
		    'address' => $this->text(),
		    'pay_id' => $this->integer()->notNull(),
		    'delivery_id' => $this->string()->notNull(),
		    'status' => $this->tinyInteger(1)->notNull()->defaultValue(0),
	    ], $tableOptions);

	    // Заказ - индекс
	    $this->createIndex(
		    'idx-site_shop_order-account_id',
		    'site_shop_order',
		    'account_id'
	    );

	    // Заказ - индекс
	    $this->createIndex(
		    'idx-site_shop_order-created_at',
		    'site_shop_order',
		    'created_at'
	    );

	    // Заказ - индекс
	    $this->createIndex(
		    'idx-site_shop_order-status',
		    'site_shop_order',
		    'status'
	    );

	    // Товары заказа
	    $this->createTable('site_shop_order_products', [
		    'id' => $this->primaryKey(),
		    'order_id' => $this->integer()->notNull(),
		    'product_id' => $this->integer()->notNull(),
		    'name' => $this->string()->notNull(),
		    'price' => $this->decimal(8, 0)->notNull(),
		    'count' => $this->integer()->notNull(),
	    ], $tableOptions);

	    // Товары заказа - индекс
	    $this->createIndex(
		    'idx-site_shop_order_products-order_id',
		    'site_shop_order_products',
		    'order_id'
	    );

	    // Товары заказа - индекс
	    $this->createIndex(
		    'idx-site_shop_order_products-product_id',
		    'site_shop_order_products',
		    'product_id'
	    );

	    // Опции товаров заказа
	    $this->createTable('site_shop_order_products_options', [
		    'id' => $this->primaryKey(),
		    'order_product_id' => $this->integer()->notNull(),
		    'product_option_id' => $this->integer()->notNull(),
	    ], $tableOptions);

	    // Опции товаров заказа - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_order_products_options-order_pid-product_oid',
		    'site_shop_order_products_options',
		    'order_product_id, product_option_id',
		    true
	    );

	    // Доставка
	    $this->createTable('site_shop_delivery', [
		    'id' => $this->primaryKey(),
		    'order' => $this->smallInteger()->notNull()->defaultValue(0),
	    ], $tableOptions);

	    // Доставка лэнг
	    $this->createTable('site_shop_delivery_lang', [
		    'id' => $this->primaryKey(),
		    'delivery_id' => $this->integer()->notNull(),
		    'lang_id' => $this->integer()->notNull(),
		    'name' => $this->string()->notNull(),
		    'description' => $this->text(),
	    ], $tableOptions);

	    // Доставка лэнг - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_delivery_lang-delivery_id-lang_id',
		    'site_shop_delivery_lang',
		    'delivery_id, lang_id',
		    true
	    );

	    // Оплата
	    $this->createTable('site_shop_pay', [
		    'id' => $this->primaryKey(),
		    'order' => $this->smallInteger()->notNull()->defaultValue(0),
		    'is_legal' => $this->tinyInteger(1)->notNull()->defaultValue(0),
	    ], $tableOptions);

	    // Оплата лэнг
	    $this->createTable('site_shop_pay_lang', [
		    'id' => $this->primaryKey(),
		    'pay_id' => $this->integer()->notNull(),
		    'lang_id' => $this->integer()->notNull(),
		    'name' => $this->string()->notNull(),
		    'description' => $this->text(),
	    ], $tableOptions);

	    // Оплата лэнг - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_pay_lang-pay_id-lang_id',
		    'site_shop_pay_lang',
		    'pay_id, lang_id',
		    true
	    );

	    // Связи
	    $this->createTable('site_shop_relation', [
		    'id' => $this->primaryKey(),
		    'key' => $this->string()->notNull(),
		    'name' => $this->string()->notNull(),
	    ], $tableOptions);

	    // Связи - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_relation-key',
		    'site_shop_relation',
		    'key',
		    true
	    );

	    // Связи товаров с товарами
	    $this->createTable('site_shop_product_relations', [
		    'id' => $this->primaryKey(),
		    'relation_id' => $this->integer()->notNull(),
		    'product_id' => $this->integer()->notNull(),
		    'linked_product_id' => $this->integer()->notNull(),
	    ], $tableOptions);

	    // Связи товаров с товарами - уникальный индекс
	    $this->createIndex(
		    'ux-site_shop_product_relations-rel_id-prod_id-linked_prod_id',
		    'site_shop_product_relations',
		    'relation_id, product_id, linked_product_id',
		    true
	    );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181113_151133_site_shop cannot be reverted.\n";

        return false;
    }
}
