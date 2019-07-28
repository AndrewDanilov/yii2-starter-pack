<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_option_value_lang".
 *
 * @property int $id
 * @property int $product_option_id
 * @property int $lang_id
 * @property string $value
 */
class ShopProductOptionsLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_product_options_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_option_id', 'lang_id', 'value'], 'required'],
            [['product_option_id', 'lang_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['product_option_id', 'lang_id'], 'unique', 'targetAttribute' => ['product_option_id', 'lang_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_option_id' => 'Product Option ID',
            'lang_id' => 'Lang ID',
            'value' => 'Value',
        ];
    }
}
