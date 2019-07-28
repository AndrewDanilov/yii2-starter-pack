<?php

namespace frontend\components;

use yii\web\Request;
use common\models\Lang;

class AppRequest extends Request
{
	private $_lang_url = null;

	/**
	 * Добавлен функционал для определения языка по url
	 * и удаления этого языка из url для дальнейшей
	 * корректной обработки маршрутными правилами.
	 *
	 * @inheritdoc
	 */
	public function getUrl()
	{
		if ($this->_lang_url === null) {
			$this->_lang_url = parent::getUrl();

			$url_list = explode('/', $this->_lang_url);

			// извелекаем из url первую часть - возможно, это ключ языка
			$lang_key = isset($url_list[1]) ? $url_list[1] : '';

			Lang::setCurrentLang($lang_key);
			$current_lang = Lang::getCurrentLang();

			// если язык присутствовал в url, то удалим его от туда
			if ($lang_key == $current_lang->key)
			{
				$this->_lang_url = substr($this->_lang_url, strlen($current_lang->key) + 1);
			}
		}

		return $this->_lang_url;
	}
}