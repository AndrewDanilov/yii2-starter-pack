<?php
namespace backend\controllers;

use Yii;
use yii\db\Query;
use yii\helpers\Json;

/**
 * Site controller for backend
 */
class SiteController extends BackendController
{
	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Вид файлового менеджера
	 *
	 * @return string
	 */
	public function actionFilemanager()
	{
		return $this->render('filemanager');
	}

	//////////////////////////////////////////////////////////////////

	public function actionClearCache()
	{
		// очистить кэш таблиц
		Yii::$app->cache->flush();
		Yii::$app->frontendCache->flush();
		return $this->render('clear-cache');
	}
}
