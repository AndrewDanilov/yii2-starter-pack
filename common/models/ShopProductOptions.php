<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_product_options".
 *
 * @property int $id
 * @property int $option_id
 * @property int $product_id
 * @property string $margin
 * @property int $margin_type
 * @property ShopOption $option
 */
class ShopProductOptions extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => 'common\behaviors\LangBehavior',
				'referenceModelClass' => 'common\models\ShopProductOptionsLang',
				'referenceModelAttribute' => 'product_option_id',
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function formName()
	{
		return 'ShopProductOptionsLang';
	}

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_product_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option_id', 'product_id', 'margin'], 'required'],
            [['option_id', 'product_id'], 'integer'],
            [['margin'], 'number'],
            [['margin_type'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'option_id' => 'Опция',
            'product_id' => 'Товар',
            'margin' => 'Наценка',
            'margin_type' => 'Тип наценки',
        ];
    }

	public function getOption()
	{
		return $this->hasOne(ShopOption::class, ['id' => 'option_id']);
	}
}
