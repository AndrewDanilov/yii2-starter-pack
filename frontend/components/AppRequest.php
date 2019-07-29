<?php

namespace frontend\components;

use Yii;
use yii\web\Request;
use common\models\Locality;

class AppRequest extends Request
{
	private $_city_url = null;

	/**
	 * Добавлен функционал для определения города по url
	 * и удаления алиаса города из url.
	 *
	 * @inheritdoc
	 */
	public function getUrl()
	{
		if ($this->_city_url === null) {
			$this->_city_url = parent::getUrl();

			$url_list = explode('/', $this->_city_url);

			$city_alias = isset($url_list[1]) ? $url_list[1] : '';

			$currentLocality = Locality::getByAlias($city_alias);
			if (!$currentLocality) {
				$currentLocality = Locality::getDefault();
			}

			Yii::$app->params['currentLocality'] = $currentLocality;

			if ($city_alias !== '' &&
				$city_alias === $currentLocality->alias &&
				strpos($this->_city_url, $currentLocality->alias) === 1)
			{
				$this->_city_url = substr($this->_city_url, strlen($currentLocality->alias) + 1);
			}
		}

		return $this->_city_url;
	}
}