<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_product_attributes_lang".
 *
 * @property int $id
 * @property int $product_attribute_id
 * @property int $lang_id
 * @property string $value
 */
class ShopProductAttributesLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_product_attributes_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_attribute_id', 'lang_id'], 'required'],
            [['product_attribute_id', 'lang_id'], 'integer'],
            [['value'], 'string'],
            [['product_attribute_id', 'lang_id'], 'unique', 'targetAttribute' => ['product_attribute_id', 'lang_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_attribute_id' => 'Product Attribute ID',
            'lang_id' => 'Lang ID',
            'value' => 'Value',
        ];
    }
}
