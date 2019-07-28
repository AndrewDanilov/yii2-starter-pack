<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use frontend\components\Sitemap;

class SitemapController extends Controller
{
	public function actionIndex()
	{
		if (!$xml = Yii::$app->cache->get('sitemap'))
		{
			$sitemap = new Sitemap();

			$sitemap->addClass('common\models\ShopBrand', ['site/brands']);
			$sitemap->addClass('common\models\ShopCategory', ['site/categories']);
			$sitemap->addClass('common\models\ShopProduct', ['site/product']);

			$sitemap->addUrl(['site/index']);
			$sitemap->addUrl(['site/policy']);
			$sitemap->addUrl(['site/contacts']);
			$sitemap->addUrl(['site/about']);

			$xml = $sitemap->render();
			Yii::$app->cache->set('sitemap', $xml, 3600);
		}

		Yii::$app->response->format = Response::FORMAT_RAW;
		$headers = Yii::$app->response->headers;
		$headers->add('Content-Type', 'application/xml');
		return $xml;
	}
}