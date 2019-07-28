<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_category_lang".
 *
 * @property int $id
 * @property int $category_id
 * @property int $lang_id
 * @property string $name
 * @property string $description
 * @property string $seo_title
 * @property string $seo_description
 * @property ShopCategory $category
 */
class ShopCategoryLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_category_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'lang_id', 'name'], 'required'],
            [['category_id', 'lang_id'], 'integer'],
            [['description', 'seo_description'], 'string'],
            [['name', 'seo_title'], 'string', 'max' => 255],
            [['category_id', 'lang_id'], 'unique', 'targetAttribute' => ['category_id', 'lang_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
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

	public function getCategory()
	{
		return $this->hasOne(ShopCategory::class, ['id' => 'category_id']);
	}
}
