<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_product_lang".
 *
 * @property int $id
 * @property int $product_id
 * @property int $lang_id
 * @property string $name
 * @property string $description
 * @property string $seo_title
 * @property string $seo_description
 */
class ShopProductLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_product_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'lang_id', 'name'], 'required'],
            [['product_id', 'lang_id'], 'integer'],
            [['description', 'seo_description'], 'string'],
            [['name', 'seo_title'], 'string', 'max' => 255],
            [['product_id', 'lang_id'], 'unique', 'targetAttribute' => ['product_id', 'lang_id']],
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
            'lang_id' => 'Lang ID',
            'name' => 'Name',
            'description' => 'Description',
            'seo_title' => 'Seo Title',
            'seo_description' => 'Seo Description',
        ];
    }
}
