<?php

namespace backend\components;

use yii\web\UrlRuleInterface;
use yii\base\BaseObject;

class UrlRule extends BaseObject implements UrlRuleInterface
{
	public function createUrl($manager, $route, $params)
	{
		if ($route === 'admin/site/index') {
			return 'admin/';
		}
		return false;
	}

	/**
	 * @param \yii\web\UrlManager $manager
	 * @param \yii\web\Request $request
	 * @return array|bool
	 * @throws \yii\base\InvalidConfigException
	 */
	public function parseRequest($manager, $request)
	{
		$pathInfo = $request->getPathInfo();
		if ($pathInfo == 'admin/') {
			return ['admin/site/index', []];
		}
		return false;
	}
}
