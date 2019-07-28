<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_attribute".
 *
 * @property int $id
 * @property string $type
 * @property int $order
 * @property ShopProduct[] $products
 */
class ShopAttribute extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => 'common\behaviors\LangBehavior',
				'referenceModelClass' => 'common\models\ShopAttributeLang',
				'referenceModelAttribute' => 'attribute_id',
			],
			[
				'class' => 'common\behaviors\TagBehavior',
				'referenceModelClass' => 'common\models\ShopCategoryAttributes',
				'referenceModelAttribute' => 'attribute_id',
				'referenceTagModelAttribute' => 'category_id',
				'tagModelClass' => 'common\models\ShopCategory',
			],
			[
				'class' => 'common\behaviors\ValueTypeBehavior',
			],
		];
	}

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_attribute';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['order'], 'integer'],
	        [['order'], 'default', 'value' => 0],
	        [['type'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'order' => 'Порядок',
            'name' => 'Название',
            'tagIds' => 'Категории',
        ];
    }

	public function getProducts()
	{
		return $this->hasMany(ShopProduct::class, ['id' => 'product_id'])->viaTable(ShopProductAttributes::tableName(), ['attribute_id' => 'id']);
	}
}
