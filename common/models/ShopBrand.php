<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site_shop_brand".
 *
 * @property int $id
 * @property string $image
 * @property int $is_favorite
 * @property int $order
 * @property ShopProduct[] $products
 * @property ShopCategory[] $categories
 * @method getFieldItemsTranslatedList($field, $lang=null)
 */
class ShopBrand extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => 'common\behaviors\LangBehavior',
				'referenceModelClass' => 'common\models\ShopBrandLang',
				'referenceModelAttribute' => 'brand_id',
			],
		];
	}

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order'], 'integer'],
            [['order'], 'default', 'value' => 0],
            [['image'], 'string', 'max' => 255],
            [['is_favorite'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Логотип',
            'is_favorite' => 'Избранный',
            'order' => 'Порядок',
            'name' => 'Название',
        ];
    }

	public function getProducts()
	{
		return $this->hasMany(ShopProduct::class, ['brand_id' => 'id']);
	}

	public function getCategories()
	{
		return $this->hasMany(ShopCategory::class, ['id' => 'category_id'])->viaTable(ShopProduct::tableName(), ['brand_id' => 'id']);
	}

	//////////////////////////////////////////////////////////////////

	public static function getBrandsList()
	{
		return self::find()->joinWith(['langsRefCurrent'])->select([ShopBrandLang::tableName() . '.name', ShopBrand::tableName() . '.id'])->indexBy('id')->column();
	}
}
