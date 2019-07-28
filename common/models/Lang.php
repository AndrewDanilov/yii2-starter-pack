<?php

namespace common\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "site_lang".
 *
 * @property int $id
 * @property string $key
 * @property int $is_default
 * @property string $name
 * @property string $image
 * @property string $currency
 * @property string $currency_value
 */
class Lang extends \yii\db\ActiveRecord
{
	/* @var Lang $_lang */
	private static $_lang = null;
	/* @var Lang[] $_langs */
	private static $_langs = null;
	/* @var string $_baseCurrency */
	private static $_baseCurrency = null;

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_lang';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'name'], 'required'],
            [['key', 'name', 'image', 'currency'], 'string', 'max' => 255],
	        [['currency_value'], 'number'],
	        [['currency_value'], 'default', 'value' => 1],
            [['is_default'], 'boolean'],
            [['key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Ключ',
            'is_default' => 'По умолчанию',
            'name' => 'Название',
            'image' => 'Иконка',
            'currency' => 'Обозначение валюты',
            'currency_value' => 'Стоимость валюты',
        ];
    }

	/**
	 * Возвращает язык по-умолчанию
	 *
	 * @return null|Lang|\yii\db\ActiveRecord
	 */
    public static function getDefaultLang()
    {
    	$lang = self::find()->where(['is_default' => 1])->limit(1)->one();
    	return $lang;
    }

	/**
	 * Возвращает текущий язык
	 *
	 * @return null|Lang|\yii\db\ActiveRecord
	 */
    public static function getCurrentLang()
    {
	    if (static::$_lang === null) {
		    static::$_lang = self::getDefaultLang();
	    }
	    return static::$_lang;
    }

	/**
	 * Сохраняет текущий язык
	 *
	 * @param $key
	 */
    public static function setCurrentLang($key)
    {
	    static::$_lang = static::getLang($key) ?: self::getDefaultLang();
	    Yii::$app->language = static::$_lang->key;
    }

	/**
	 * Возвращает язык по ID или текстовому обозначению.
	 *
	 * @param int|string $key
	 * @return null|Lang|\yii\db\ActiveRecord
	 */
    public static function getLang($key)
    {
    	if (static::$_langs === null || !isset(static::$_langs[$key])) {
		    if (is_numeric($key)) {
			    $lang = self::find()->limit(1)->where(['id' => $key])->one();
		    } else {
			    $lang = self::find()->limit(1)->where(['key' => $key])->one();
		    }
		    static::$_langs[$lang->id] = $lang;
		    static::$_langs[$lang->key] = $lang;
	    }
	    return static::$_langs[$key];
    }

	/**
	 * Возвращает иконку языка по ID или текстовому обозначению
	 * в виде html-тега, либо его текстовое обозначение,
	 * в случае отсутствия иконки
	 *
	 * @param $key
	 * @return string
	 */
	public static function getLangIcon($key)
	{
		$lang = static::getLang($key);
		return $lang->image ? Html::img($lang->image, ['height' => '16']) : '[' . $lang->key . ']';
	}

	/**
	 * Возвращает валюту текущего языка
	 *
	 * @return string
	 */
	public static function getCurrency()
	{
		$lang = self::getCurrentLang();
		return $lang->currency;
	}

	/**
	 * Возвращает стоимость валюты текущего языка
	 *
	 * @return string
	 */
	public static function getCurrencyValue()
	{
		$lang = self::getCurrentLang();
		return $lang->currency_value;
	}

	/**
	 * Возвращает базовую валюту (стоимость которой равна 1)
	 *
	 * @return string
	 */
	public static function getBaseCurrency()
	{
		if (static::$_baseCurrency === null) {
			$lang = static::find()->where(['currency_value' => 1])->one();
			static::$_baseCurrency = $lang->currency;
		}
		return static::$_baseCurrency;
	}
}
