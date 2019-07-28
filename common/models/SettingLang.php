<?php

namespace common\models;

use yii\base\Model;
use common\behaviors\ValueTypeBehavior;

/**
 * This is the model class for table "site_setting_lang".
 *
 * @property int $id
 * @property int $setting_id
 * @property int $lang_id
 * @property mixed $value
 * @property Setting $setting
 */
class SettingLang extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_setting_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['setting_id', 'lang_id'], 'required'],
            [['setting_id', 'lang_id'], 'integer'],
	        [['value'], 'boolean', 'on' => ValueTypeBehavior::VALUE_TYPE_BOOLEAN],
	        [['value'], 'integer', 'on' => ValueTypeBehavior::VALUE_TYPE_INTEGER],
	        [['value'], 'string', 'on' => Model::SCENARIO_DEFAULT],
            [['setting_id', 'lang_id'], 'unique', 'targetAttribute' => ['setting_id', 'lang_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'setting_id' => 'Setting ID',
            'lang_id' => 'Lang ID',
            'value' => 'Value',
        ];
    }

	public function getSetting()
    {
    	return $this->hasOne(Setting::class, ['id' => 'setting_id']);
    }
}
