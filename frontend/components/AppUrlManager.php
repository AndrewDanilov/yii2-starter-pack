<?php

namespace frontend\components;

use yii\web\UrlManager;
use common\models\Lang;

class AppUrlManager extends UrlManager
{
	public function createUrl($params)
	{
		if (isset($params['lang'])) {
			$lang = Lang::getLang($params['lang']);
			unset($params['lang']);
		} else {
			$lang = Lang::getCurrentLang();
		}
		$url = parent::createUrl($params);
		if ($lang && !$lang->is_default) {
			$url = '/' . trim($lang->key . $url, '/');
		}
		return $url;
	}
}