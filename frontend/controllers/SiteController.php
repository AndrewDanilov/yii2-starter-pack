<?php
namespace frontend\controllers;

use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Account;
use common\models\LoginForm;
use frontend\models\FeedbackForm;
use frontend\models\RegisterForm;
use frontend\models\PasswordForm;
use frontend\models\ProfileForm;
use frontend\models\RecoverForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
		];
	}

	/**
	 * Index action.
	 *
	 * @return mixed
	 */
	public function actionIndex()
	{
		$this->layout = 'main';
		return $this->render('index');
	}

	/**
	 * Error action.
	 *
	 * @return mixed
	 */
	public function actionError()
	{
		$this->layout = 'main';
		return $this->render('404');
	}

	/**
	 * Month action.
	 *
	 * @return mixed
	 */
	public function actionMonth()
	{
		$this->layout = 'main';
		return $this->render('month');
	}

	/**
	 * Login action.
	 *
	 * @param null|string $redirect
	 * @return Response|string
	 */
	public function actionLogin($redirect=null)
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
			if ($redirect) {
				return $this->redirect($redirect);
			}
			return $this->goBack();
		}
		$this->layout = 'enter';
		return $this->render('enter', [
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
		return $this->goBack();
	}

	/**
	 * Profile action.
	 *
	 * @return mixed
	 */
	public function actionProfile()
	{
		if (Yii::$app->user->isGuest) {
			return $this->redirect(['site/enter', 'redirect' => Url::to(['site/profile'])]);
		}

		$account = Account::getCurrentUser();
		$model = new ProfileForm();
		$model->load($account->getAttributes($model->attributes()), '');

		if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {

			if ($account->load($model->attributes, '') && $account->save()) {
				Yii::$app->session->setFlash('success', true);
				return $this->redirect(['site/profile']);
			}
			$model->addErrors($account->errors);
		}

		return $this->render('profile', ['model' => $model]);
	}

	/**
	 * ChangePassword action.
	 *
	 * @return mixed
	 */
	public function actionChangePassword()
	{
		if (Yii::$app->user->isGuest) {
			return $this->redirect(['site/enter', 'redirect' => Url::to(['site/change-password'])]);
		}

		$model = new PasswordForm();

		if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
			$account = Account::getCurrentUser();
			$account->password = $model->password;
			if ($account->save()) {
				Yii::$app->session->setFlash('success', true);
				return $this->redirect(['site/change-password']);
			}
			$model->addErrors($account->errors);
		}

		return $this->render('change-password', ['model' => $model]);
	}

	/**
	 * RecoverPassword action.
	 *
	 * @return mixed
	 */
	public function actionRecoverPassword()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->redirect(['site/profile']);
		}

		$model = new RecoverForm();

		if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
			$account = Account::findUser($model->email);
			if ($account) {
				$account->sendRecover();
				Yii::$app->session->setFlash('success', true);
				return $this->redirect(['site/forgot']);
			}
			$model->addError('email', Yii::t('site', 'Пользователя с таким E-mail нет в системе'));
		}

		$this->layout = 'enter';
		return $this->render('forgot', ['model' => $model]);
	}

	/**
	 * Resets password.
	 *
	 * @param string $token
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionResetPassword($token)
	{
		$model = Account::findUserByResetToken($token);

		if ($model && $model->resetPassword()) {
			Yii::$app->session->setFlash('success', Yii::t('site', 'Новый пароль сохранен. Проверьте почтовый ящик.'));
		} else {
			Yii::$app->session->setFlash('error', Yii::t('site', 'Не удалось изменить пароль'));
		}
		return $this->redirect(['site/enter']);
	}

	/**
	 * Register action.
	 *
	 * @return mixed
	 */
	public function actionRegister()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$model = new RegisterForm();

		if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
			$account = Account::register(ArrayHelper::toArray($model), true, true);
			if ($account->hasErrors()) {
				$model->addErrors($account->errors);
			} else {
				$this->goHome();
			}
		}

		$this->layout = 'enter';
		return $this->render('registration', ['model' => $model]);
	}

	/**
	 * Отправка писем
	 *
	 * @return array
	 * @throws BadRequestHttpException
	 */
	public function actionFeedback()
	{
		if (Yii::$app->request->isAjax) {
			if (Yii::$app->request->isPost) {

				$model = new FeedbackForm();
				if ($model->load(Yii::$app->request->post(), '')) {
					Yii::$app->response->format = Response::FORMAT_JSON;
					if ($model->sendFeedback()) {
						return ['success' => '1'];
					} else {
						return ['errors' => $model->errors];
					}
				}

			}
		}
		throw new BadRequestHttpException("Error request");
	}

	/**
	 * Контроллер для предварительной настройки приложения,
	 * создания необходимых записей в БД, ролей пользователей
	 * и настроек по умолчанию.
	 * ВНИМАНИЕ!!! УДАЛИТЬ ПОСЛЕ ПЕРВОГО ПРИМЕНЕНИЯ!
	 * @throws \Exception
	 */
	public function actionAfterInstall()
	{
		// Очищаем кэш
		$frontend_cache_dir = Yii::getAlias('@frontend/runtime/cache');
		$console_cache_dir = Yii::getAlias('@console/runtime/cache');
		$common_cache_dir = Yii::getAlias('@common/runtime/cache');
		ob_start();
		echo "<pre>";
		echo "Clearing frontend cache: " . $frontend_cache_dir . "\n";
		system('rm -rf ' . $frontend_cache_dir . '/* 2>&1');
		echo "Clearing common cache: " . $common_cache_dir . "\n";
		system('rm -rf ' . $common_cache_dir . '/* 2>&1');
		echo "Clearing console cache: " . $console_cache_dir . "\n";
		system('rm -rf ' . $console_cache_dir . '/* 2>&1');
		// Накатываем миграции
		defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
		defined('STDOUT') or define('STDOUT', fopen('php://stdout', 'w'));
		defined('STDERR') or define('STDERR', fopen('php://stderr', 'w'));
		$migration = new \yii\console\controllers\MigrateController('migrate', Yii::$app);
		$status = $migration->runAction('up', ['migrationPath' => '@console/migrations', 'interactive' => false]);
		if ($status == 0) {
			echo "init migrations set.\n";
		}
		$migration = new \yii\console\controllers\MigrateController('migrate', Yii::$app);
		$status = $migration->runAction('up', ['migrationPath' => '@yii/rbac/migrations', 'interactive' => false]);
		if ($status == 0) {
			echo "rbac migrations set.\n";
		}
		echo "</pre>";
		$response = ob_get_contents();
		ob_end_clean();
		// Создаем роль админа
		$role = Yii::$app->authManager->createRole('admin');
		$role->description = 'Администратор';
		Yii::$app->authManager->add($role);
		$response .= 'done create role admin.<br>';
		// Создаем аккаунт пользователя
		$account = \common\models\Account::find()->joinWith('userRel')->where([\common\models\User::tableName() . '.email' => 'admin@example.com'])->one();
		if (empty($account)) {
			$account = new \common\models\Account();
			$account->user->email = 'admin@example.com';
		}
		$account->user->username = 'admin@example.com';
		$account->user->setPassword('admin100100');
		$account->user->generateAuthKey();
		$account->name = 'Администратор';
		$account->isAdmin = true;
		if ($account->save(false)) {
			$response .= 'done create/renew account for admin@example.com<br>';
		}
		// Заменяем request-класс на собственный
		$config_file = Yii::getAlias('@frontend/config/main.php');
		$config = file_get_contents($config_file);
		$config = str_replace("'class' => 'yii\web\Request'", "'class' => 'frontend\components\AppRequest'", $config);
		file_put_contents($config_file, $config);
		$response .= 'done config change.<br>';
		// Готово
		$response .= 'please, remove actionAfterInstall() method from SiteController.php<br>';
		return $response;
	}
}