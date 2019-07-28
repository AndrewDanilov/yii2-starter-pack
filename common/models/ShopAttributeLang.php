<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_attribute_lang".
 *
 * @property int $id
 * @property int $attribute_id
 * @property int $lang_id
 * @property string $name
 * @property Lang $lang
 * @property ShopAttribute $shopAttribute
 */
class ShopAttributeLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_attribute_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id', 'lang_id', 'name'], 'required'],
            [['attribute_id', 'lang_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['attribute_id', 'lang_id'], 'unique', 'targetAttribute' => ['attribute_id', 'lang_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'attribute_id' => 'Attribute ID',
            'lang_id' => 'Lang ID',
            'name' => 'Name',
        ];
    }

	public function getShopAttribute()
	{
		return $this->hasOne(ShopAttribute::class, ['id' => 'attribute_id']);
	}
}
