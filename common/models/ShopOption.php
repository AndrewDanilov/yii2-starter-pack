<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_option".
 *
 * @property int $id
 * @property int $order
 * @property ShopProduct[] $products
 */
class ShopOption extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => 'common\behaviors\LangBehavior',
				'referenceModelClass' => 'common\models\ShopOptionLang',
				'referenceModelAttribute' => 'option_id',
			],
			[
				'class' => 'common\behaviors\TagBehavior',
				'referenceModelClass' => 'common\models\ShopCategoryOptions',
				'referenceModelAttribute' => 'option_id',
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
        return 'site_shop_option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order'], 'integer'],
	        [['order'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order' => 'Порядок',
	        'name' => 'Название',
	        'tagIds' => 'Категории',
        ];
    }

	public function getProducts()
	{
		return $this->hasMany(ShopProduct::class, ['id' => 'product_id'])->viaTable(ShopProductOptions::tableName(), ['option_id' => 'id']);
	}
}
