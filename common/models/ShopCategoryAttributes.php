<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site_shop_category_attributes".
 *
 * @property int $id
 * @property int $attribute_id
 * @property int $category_id
 */
class ShopCategoryAttributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_category_attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id', 'category_id'], 'required'],
            [['attribute_id', 'category_id'], 'integer'],
            [['attribute_id', 'category_id'], 'unique', 'targetAttribute' => ['attribute_id', 'category_id']],
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
            'category_id' => 'Category ID',
        ];
    }
}
