<?php

namespace common\models;

use common\behaviors\ShopOptionBehavior;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "site_shop_product".
 *
 * @property int $id
 * @property string $article
 * @property int $brand_id
 * @property string $old_price
 * @property string $price
 * @property bool $is_popular
 * @property ShopBrand $brand
 * @property ShopOrder[] $orders
 * @property ActiveQuery $tags
 * @property ShopOption[] $availableOptions
 * @property ShopAttribute[] $availableAttributes
 * @property string $categoriesDelimitedString
 * @property array $availableCategoryOptions
 * @property array $availableCategoryAttributes
 * @property \common\models\ShopProductAttributes[] $productAttributes
 * @property \common\models\ShopProductOptions[] $productOptions
 * @property \common\models\ShopProductOptions[] $defaultProductOptions
 * @property string|float|int $priceWithMargin
 * @method ActiveQuery getTags()
 */
class ShopProduct extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => 'common\behaviors\LangBehavior',
				'referenceModelClass' => 'common\models\ShopProductLang',
				'referenceModelAttribute' => 'product_id',
			],
			[
				'class' => 'common\behaviors\TagBehavior',
				'referenceModelClass' => 'common\models\ShopProductCategories',
				'referenceModelAttribute' => 'product_id',
				'referenceTagModelAttribute' => 'category_id',
				'tagModelClass' => 'common\models\ShopCategory',
			],
			'shopAttributes' => [
				'class' => 'common\behaviors\ShopOptionBehavior',
				'referenceModelClass' => 'common\models\ShopProductAttributes',
				'referenceModelAttribute' => 'product_id',
				'referenceOptionModelAttribute' => 'attribute_id',
				'optionModelClass' => 'common\models\ShopAttribute',
				'createDefaultValues' => true,
			],
			'shopOptions' => [
				'class' => 'common\behaviors\ShopOptionBehavior',
				'referenceModelClass' => 'common\models\ShopProductOptions',
				'referenceModelAttribute' => 'product_id',
				'referenceOptionModelAttribute' => 'option_id',
				'optionModelClass' => 'common\models\ShopOption',
			],
			[
				'class' => 'common\behaviors\LinkedProductsBehavior',
			],
			[
				'class' => 'common\behaviors\ImagesBehavior',
				'imagesModelClass' => 'common\models\ShopProductImages',
				'imagesModelRefAttribute' => 'product_id',
			]
		];
	}

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_id', 'is_popular'], 'integer'],
	        [['is_popular'], 'default', 'value' => 0],
            [['old_price', 'price'], 'number'],
            [['old_price', 'price'], 'default', 'value' => 0],
	        [['article'], 'string', 'max' => 255],
	        [['article'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article' => 'Артикул',
            'brand_id' => 'Бренд',
            'old_price' => 'Старая цена',
            'price' => 'Цена',
            'category_id' => 'Категории',
            'tagIds' => 'Категории',
	        'name' => 'Название',
	        'is_popular' => 'Популярный',
            'images' => 'Изображения',
	        'image' => 'Изображение',
        ];
    }

    public function getBrand()
    {
    	return $this->hasOne(ShopBrand::class, ['id' => 'brand_id']);
    }

    public function getOrders()
    {
    	return $this->hasMany(ShopOrder::class, ['id' => 'order_id'])->viaTable(ShopOrderProducts::tableName(), ['product_id' => 'id']);
    }

    public function getAvailableCategoryAttributes()
    {
    	return $this->hasMany(ShopCategoryAttributes::class, ['category_id' => 'id'])->via('tags');
    }

    public function getAvailableCategoryOptions()
    {
    	return $this->hasMany(ShopCategoryOptions::class, ['category_id' => 'id'])->via('tags');
    }

    public function getAvailableAttributes() {
    	return $this->hasMany(ShopAttribute::class, ['id' => 'attribute_id'])->via('availableCategoryAttributes');
    }

    public function getAvailableOptions() {
    	return $this->hasMany(ShopOption::class, ['id' => 'option_id'])->via('availableCategoryOptions');
    }

    //////////////////////////////////////////////////////////////////

	/**
	 * @return ShopProductAttributes[]
	 */
	public function getProductAttributes()
	{
		/* @var $behavior ShopOptionBehavior */
		$behavior = $this->getBehavior('shopAttributes');
		return $behavior->getOptionsRef()->all();
	}

	/**
	 * @param null|string|array $productOptionsIds
	 * @return ShopProductOptions[]
	 */
	public function getProductOptions($productOptionsIds=null)
	{
		/* @var $behavior ShopOptionBehavior */
		$behavior = $this->getBehavior('shopOptions');
		$productOptions = $behavior->getOptionsRef();
		if ($productOptionsIds !== null) {
			if (!is_array($productOptionsIds)) {
				$productOptionsIds = explode(',', $productOptionsIds);
			}
			$productOptions->where(['id' => $productOptionsIds]);
		}
		return $productOptions->all();
	}

	/**
	 * @return ShopProductOptions[]
	 */
	public function getDefaultProductOptions()
	{
		/* @var $behavior ShopOptionBehavior */
		$behavior = $this->getBehavior('shopOptions');
		return $behavior->getOptionsRef()->orderBy(ShopProductOptions::tableName() . '.id')->groupBy('option_id')->all();
	}

    //////////////////////////////////////////////////////////////////

	public function getPriceWithMargin($productOptionsIds=null)
	{
		$price = $this->price;
		if ($productOptionsIds === null) {
			$productOptions = $this->defaultProductOptions;
		} else {
			$productOptions = $this->getProductOptions($productOptionsIds);
		}
		foreach ($productOptions as $productOption) {
			$price += $productOption->margin_type == 1 ? $productOption->margin : ($this->price * $productOption->margin / 100);
		}
		return $price;
	}

    //////////////////////////////////////////////////////////////////

    public function getCategoriesDelimitedString()
    {
    	$allCategories = (new ShopCategory())->getFieldItemsTranslatedList('name');
    	$categories = $this->getTags()->select('id')->indexBy('id')->column();
    	$categories = array_intersect_key($allCategories, $categories);
    	return implode(', ', $categories);
    }
}
