<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_brand_lang".
 *
 * @property int $id
 * @property int $brand_id
 * @property int $lang_id
 * @property string $name
 * @property string $description
 * @property string $seo_title
 * @property string $seo_description
 * @property Lang $lang
 * @property ShopBrand $brand
 */
class ShopBrandLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_brand_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_id', 'lang_id', 'name'], 'required'],
            [['brand_id', 'lang_id'], 'integer'],
            [['description', 'seo_description'], 'string'],
            [['name', 'seo_title'], 'string', 'max' => 255],
            [['brand_id', 'lang_id'], 'unique', 'targetAttribute' => ['brand_id', 'lang_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand ID',
            'lang_id' => 'Lang ID',
            'name' => 'Name',
            'description' => 'Description',
            'seo_title' => 'Seo Title',
            'seo_description' => 'Seo Description',
        ];
    }

	public function getLang()
	{
		return $this->hasOne(Lang::class, ['id' => 'lang_id']);
	}

	public function getBrand()
	{
		return $this->hasOne(ShopBrand::class, ['id' => 'brand_id']);
	}
}
