<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_order_products".
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $name
 * @property string $price
 * @property int $count
 * @property ShopOrder $order
 * @property ShopProduct $product
 * @property ShopOrderProductsOptions[] $orderProductsOptions
 * @property ShopProductOptions[] $productOptions
 * @property ShopOption[] $options
 * @property string $productOptionsStr
 */
class ShopOrderProducts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_order_products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id', 'name', 'price', 'count'], 'required'],
            [['order_id', 'product_id', 'count'], 'integer'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '№ заказа',
            'product_id' => 'ID Товара',
            'product_option_id' => 'ID Опции',
            'name' => 'Название',
            'price' => 'Цена',
            'count' => 'Количество',
            'image' => 'Изображение',
            'option' => 'Опции',
            'summ' => 'Сумма',
        ];
    }

    public function getOrder()
    {
    	return $this->hasOne(ShopOrder::class, ['id' => 'order_id']);
    }

    public function getProduct()
    {
    	return $this->hasOne(ShopProduct::class, ['id' => 'product_id']);
    }

    public function getOrderProductsOptions()
    {
    	return $this->hasMany(ShopOrderProductsOptions::class, ['order_product_id' => 'id']);
    }

    public function getProductOptions()
    {
    	return $this->hasMany(ShopProductOptions::class, ['id' => 'product_option_id'])->via('orderProductsOptions');
    }

    public function getOptions()
    {
    	return $this->hasMany(ShopOption::class, ['id' => 'option_id'])->via('productOptions');
    }

    //////////////////////////////////////////////////////////////////

    public function beforeDelete()
    {
	    foreach ($this->orderProductsOptions as $model) {
		    $model->delete();
	    }
	    return parent::beforeDelete();
    }

    //////////////////////////////////////////////////////////////////

    public function getProductOptionsStr()
    {
	    /* @var \common\models\ShopOrderProducts $model */
	    /* @var \common\models\ShopProductOptions[]|\common\behaviors\LangBehavior[] $product_options */
	    $product_options = $this->productOptions;
	    $html = [];
	    foreach ($product_options as $product_option) {
		    /* @var \common\models\ShopOption|\common\behaviors\LangBehavior $option */
		    $option = $product_option->option;
		    $html[] = $option->lang->name . ': ' . $product_option->lang->value;
	    }
	    return implode('<br/>', $html);
    }
}
