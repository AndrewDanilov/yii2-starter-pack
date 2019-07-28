<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_pay".
 *
 * @property int $id
 * @property int $order
 * @property bool $is_legal
 */
class ShopPay extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => 'common\behaviors\LangBehavior',
				'referenceModelClass' => 'common\models\ShopPayLang',
				'referenceModelAttribute' => 'pay_id',
			],
		];
	}

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_pay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order', 'is_legal'], 'integer'],
	        [['order', 'is_legal'], 'default', 'value' => 0],
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
            'is_legal' => 'Для юр.лиц',
            'name' => 'Название',
        ];
    }

	//////////////////////////////////////////////////////////////////

	public static function getPayList()
	{
		return self::find()->joinWith(['langsRefCurrent'])->select([ShopPayLang::tableName() . '.name', ShopPay::tableName() . '.id'])->indexBy('id')->column();
	}
}
