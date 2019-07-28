<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_product_attributes".
 *
 * @property int $id
 * @property int $product_id
 * @property int $attribute_id
 * @property ShopAttribute $shopAttribute
 */
class ShopProductAttributes extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => 'common\behaviors\LangBehavior',
				'referenceModelClass' => 'common\models\ShopProductAttributesLang',
				'referenceModelAttribute' => 'product_attribute_id',
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function formName()
	{
		return 'ShopProductAttributesLang';
	}

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_product_attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id', 'product_id'], 'required'],
            [['attribute_id', 'product_id'], 'integer'],
            [['attribute_id', 'product_id'], 'unique', 'targetAttribute' => ['attribute_id', 'product_id']],
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
            'product_id' => 'Product ID',
        ];
    }

    public function getShopAttribute()
    {
    	return $this->hasOne(ShopAttribute::class, ['id' => 'attribute_id']);
    }
}
