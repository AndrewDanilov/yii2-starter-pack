<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_delivery".
 *
 * @property int $id
 * @property int $order
 */
class ShopDelivery extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => 'common\behaviors\LangBehavior',
				'referenceModelClass' => 'common\models\ShopDeliveryLang',
				'referenceModelAttribute' => 'delivery_id',
			],
		];
	}

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_delivery';
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
        ];
    }

	//////////////////////////////////////////////////////////////////

	public static function getDeliveryList()
	{
		return self::find()->joinWith(['langsRefCurrent'])->select([ShopDeliveryLang::tableName() . '.name', ShopDelivery::tableName() . '.id'])->indexBy('id')->column();
	}
}
