<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_order_products_options".
 *
 * @property int $id
 * @property int $order_product_id
 * @property int $product_option_id
 */
class ShopOrderProductsOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_order_products_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_product_id', 'product_option_id'], 'required'],
            [['order_product_id', 'product_option_id'], 'integer'],
            [['order_product_id', 'product_option_id'], 'unique', 'targetAttribute' => ['order_product_id', 'product_option_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_product_id' => 'Order Product ID',
            'product_option_id' => 'Product Option ID',
        ];
    }
}
