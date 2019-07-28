<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_product_images".
 *
 * @property int $id
 * @property int $product_id
 * @property string $image
 * @property int $order
 */
class ShopProductImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_product_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'image'], 'required'],
            [['product_id', 'order'], 'integer'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'image' => 'Image',
            'order' => 'Order',
        ];
    }
}
