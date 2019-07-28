<?php

namespace common\models;

/**
 * This is the model class for table "site_shop_option_lang".
 *
 * @property int $id
 * @property int $option_id
 * @property int $lang_id
 * @property string $name
 * @property Lang $lang
 * @property ShopOption $option
 */
class ShopOptionLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_option_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['option_id', 'lang_id', 'name'], 'required'],
            [['option_id', 'lang_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['option_id', 'lang_id'], 'unique', 'targetAttribute' => ['option_id', 'lang_id']],
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
            'lang_id' => 'Lang ID',
            'name' => 'Name',
        ];
    }

	public function getOption()
	{
		return $this->hasOne(ShopOption::class, ['id' => 'option_id']);
	}
}
