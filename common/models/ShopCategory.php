<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_category".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $image
 * @property int $order
 * @property ShopProduct[] $products
 * @property ShopAttribute[] $shopAttributes
 * @property ShopOption[] $options
 * @property ShopBrand[] $brands
 * @property ShopCategory $parent
 * @property ShopCategory[] $children
 * @method getFieldItemsTranslatedList($field, $lang = null)
 */
class ShopCategory extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => 'common\behaviors\LangBehavior',
				'referenceModelClass' => 'common\models\ShopCategoryLang',
				'referenceModelAttribute' => 'category_id',
			],
		];
	}

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'order'], 'integer'],
            [['parent_id', 'order'], 'default', 'value' => 0],
            [['parent_id'], 'validateParent'],
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
            'parent_id' => 'Родительская категория',
            'image' => 'Обложка',
            'order' => 'Порядок',
            'name' => 'Название',
        ];
    }

	public function getProducts()
	{
		return $this->hasMany(ShopProduct::class, ['id' => 'product_id'])->viaTable(ShopProductCategories::tableName(), ['category_id' => 'id']);
	}

	public function getBrands()
	{
		return $this->hasMany(ShopBrand::class, ['id' => 'brand_id'])->via('products');
	}

	public function getOptions()
	{
		return $this->hasMany(ShopOption::class, ['id' => 'option_id'])->viaTable(ShopCategoryOptions::tableName(), ['category_id' => 'id']);
	}

	public function getShopAttributes()
	{
		return $this->hasMany(ShopAttribute::class, ['id' => 'attribute_id'])->viaTable(ShopCategoryAttributes::tableName(), ['category_id' => 'id']);
	}

	/**
	 * Связь с родительской категорией
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getParent()
	{
		return $this->hasOne(ShopCategory::class, ['id' => 'parent_id']);
	}

	/**
	 * Связь с непосредственными дочерними категориями
	 *
	 * @return \yii\db\ActiveQuery
	 */
	public function getChildren()
	{
		return $this->hasMany(ShopCategory::class, ['parent_id' => 'id']);
	}

	//////////////////////////////////////////////////////////////////

	/**
	 * Validates parent category.
	 *
	 * @param string $attribute the attribute currently being validated
	 * @param array $params the additional name-value pairs given in the rule
	 */
	public function validateParent($attribute, $params)
	{
		if (!$this->hasErrors()) {
			if ($this->{$attribute} == $this->id) {
				$this->addError($attribute, 'Категория не может быть вложена в саму себя');
			}
		}
	}

	//////////////////////////////////////////////////////////////////

	public static function getCategoriesList()
	{
		return self::find()->joinWith(['langsRefCurrent'])->select([ShopCategoryLang::tableName() . '.name', ShopCategory::tableName() . '.id'])->indexBy('id')->column();
	}
}
