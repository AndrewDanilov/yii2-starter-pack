<?php
namespace backend\controllers;

use Yii;
use yii\caching\CacheInterface;
use andrewdanilov\adminpanel\controllers\BackendController;
use andrewdanilov\adminpanel\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends BackendController
{
	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Login action.
	 *
	 * @return string
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		} else {
			$model->password = '';

			return $this->render('login', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Logout action.
	 *
	 * @return string
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
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

	/**
	 * Очистка кэша
	 *
	 * @return string
	 */
	public function actionClearCache()
	{
		Yii::$app->cache->flush();
		if (isset(Yii::$app->frontendCache) && Yii::$app->frontendCache instanceof CacheInterface) {
			Yii::$app->frontendCache->flush();
		}
		$this->getView()->title = 'Управление кэшем';
		return $this->renderContent('Кэш очищен');
	}
}