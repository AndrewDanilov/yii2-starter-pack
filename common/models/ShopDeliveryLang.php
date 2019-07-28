<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_delivery_lang".
 *
 * @property int $id
 * @property int $delivery_id
 * @property int $lang_id
 * @property string $name
 * @property string $description
 * @property ShopDelivery $delivery
 */
class ShopDeliveryLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_delivery_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['delivery_id', 'lang_id', 'name'], 'required'],
            [['delivery_id', 'lang_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['delivery_id', 'lang_id'], 'unique', 'targetAttribute' => ['delivery_id', 'lang_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'delivery_id' => 'ShopDelivery ID',
            'lang_id' => 'Lang ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

	public function getLang()
	{
		return $this->hasOne(Lang::class, ['id' => 'lang_id']);
	}

	public function getDelivery()
	{
		return $this->hasOne(ShopDelivery::class, ['id' => 'delivery_id']);
	}
}
