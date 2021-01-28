<?php
namespace frontend\components;

use yii\web\UrlRuleInterface;
use yii\base\BaseObject;

class UrlRule extends BaseObject implements UrlRuleInterface
{
	public function createUrl($manager, $route, $params)
	{
		if ($route === 'site/index') {
			if (isset($params['manufacturer'], $params['model'])) {
				return $params['manufacturer'] . '/' . $params['model'];
			} elseif (isset($params['manufacturer'])) {
				return $params['manufacturer'];
			}
		}
		return false; // данное правило не применимо
	}

	public function parseRequest($manager, $request)
	{
		$pathInfo = $request->getPathInfo();
		if (preg_match('~^(\w+)(?:/(\w+))?$~u', $pathInfo, $matches)) {
			$params = [];
			if (isset($matches[1])) {
				$params['manufacturer'] = $matches[1];
			}
			if (isset($matches[2])) {
				$params['model'] = $matches[2];
			}
			return ['site/index', $params];
		}
		return false; // данное правило не применимо
	}
}