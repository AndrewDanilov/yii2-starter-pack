<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site_shop_category_options".
 *
 * @property int $id
 * @property int $option_id
 * @property int $category_id
 */
class ShopCategoryOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_category_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option_id', 'category_id'], 'required'],
            [['option_id', 'category_id'], 'integer'],
            [['option_id', 'category_id'], 'unique', 'targetAttribute' => ['option_id', 'category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'option_id' => 'Option ID',
            'category_id' => 'Category ID',
        ];
    }
}
