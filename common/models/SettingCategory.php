<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site_setting_category".
 *
 * @property int $id
 * @property string $name
 * @property int $order
 * @property Setting[] $settings
 */
class SettingCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_setting_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['order'], 'integer'],
            [['order'], 'default', 'value' => 0],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'order' => 'Порядок',
        ];
    }

	public function getSettings()
	{
		return $this->hasMany(Setting::class, ['category_id' => 'id']);
	}
}
