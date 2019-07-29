<?php

namespace frontend\components;

use common\models\Locality;
use yii\web\UrlManager;

class AppUrlManager extends UrlManager
{
	public function createUrl($params)
	{
		if (isset($params['locality'])) {
			$locality = Locality::getByAlias($params['locality']);
			unset($params['locality']);
		} else {
			$locality = Locality::getCurrent();
		}
		$url = parent::createUrl($params);
		if ($locality && $locality->alias !== '') {
			$url = '/' . trim($locality->alias . $url, '/');
		}
		return $url;
	}
}