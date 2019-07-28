<?php

namespace common\models;

use common\behaviors\LangBehavior;
use common\behaviors\ValueTypeBehavior;

/**
 * This is the model class for table "site_setting".
 *
 * @property int $id
 * @property int $category_id
 * @property string $key
 * @property string $name
 * @property string $type
 * @property SettingCategory $category
 */
class Setting extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => 'common\behaviors\LangBehavior',
				'referenceModelClass' => 'common\models\SettingLang',
				'referenceModelAttribute' => 'setting_id',
			],
			[
				'class' => 'common\behaviors\ValueTypeBehavior',
			],
		];
	}

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'key', 'type', 'name'], 'required'],
            [['category_id'], 'integer'],
            [['type', 'name'], 'string'],
            [['key'], 'unique'],
            [['key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Раздел',
            'key' => 'Параметр',
            'type' => 'Тип',
            'name' => 'Название',
            'value' => 'Значение',
        ];
    }

	public function getCategory()
	{
		return $this->hasOne(SettingCategory::class, ['id' => 'category_id']);
	}

	//////////////////////////////////////////////////////////////////

	/**
	 * Возвращает значение параметра по его ключу,
	 * в соответствии с его типом.
	 *
	 * @param $key
	 * @return bool|int|string|null
	 */
	public static function getValue($key)
	{
		/* @var $param Setting|LangBehavior|ValueTypeBehavior */
		$param = self::find()->where(['key' => $key])->one();
		if ($param) {
			$lang = $param->getLang();
			return $param->formatValue($lang->value);
		}
		return null;
	}

	/**
	 * Сохраняет значение параметра
	 *
	 * @param $key
	 * @param $value
	 */
	public static function setValue($key, $value)
	{
		/* @var $param Setting|LangBehavior|ValueTypeBehavior */
		$param = self::find()->where(['key' => $key])->one();
		if ($param) {
			$lang = $param->getLang();
			$lang->value = $param->formatValue($value);
			$lang->save();
		}
	}

	/**
	 * Проверяет существование параметра с переданным ключом
	 *
	 * @param $key
	 * @return bool
	 */
	public static function hasValue($key)
	{
		/* @var $param Setting|\common\behaviors\LangBehavior */
		$param = self::find()->where(['key' => $key])->one();
		return $param && $param->getLang();
	}
}
