<?php
namespace backend\controllers;

use Yii;
use common\models\Account;
use common\models\LoginForm;
use yii\web\Response;

/**
 * Site controller for backend
 */
class SiteController extends BackendController
{
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}
		if (Yii::$app->getSession()->getFlash('error') == 'access-denied') {
			// если попали на страницу логина из-за запрета доступа
			$model->addError('email', 'Access denied for this user.');
		}
		$this->layout = '//main-login';
		return $this->render('login', [
			'model' => $model,
		]);
	}

	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();
		return $this->goHome();
	}

	/**
	 * Renders the index view for the module
	 * @return string
	 */
	public function actionIndex()
	{
		$account = Account::getCurrentUser();
		return $this->render('index', ['account' => $account]);
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

	public function actionClearCache()
	{
		// очистить кэш таблиц
		Yii::$app->cache->flush();
		Yii::$app->frontendCache->flush();
		return $this->render('clear-cache');
	}
}
