<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_pay_lang".
 *
 * @property int $id
 * @property int $pay_id
 * @property int $lang_id
 * @property string $name
 * @property string $description
 * @property Lang $lang
 * @property ShopPay $pay
 */
class ShopPayLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_pay_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_id', 'lang_id', 'name'], 'required'],
            [['pay_id', 'lang_id'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['pay_id', 'lang_id'], 'unique', 'targetAttribute' => ['pay_id', 'lang_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_id' => 'ShopPay ID',
            'lang_id' => 'Lang ID',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

	public function getLang()
	{
		return $this->hasOne(Lang::class, ['id' => 'lang_id']);
	}

	public function getPay()
    {
    	return $this->hasOne(ShopPay::class, ['id' => 'pay_id']);
    }
}
