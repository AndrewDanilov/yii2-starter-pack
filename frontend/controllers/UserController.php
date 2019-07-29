<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use common\models\User;
use common\forms\LoginForm;
use frontend\forms\RegisterForm;
use frontend\forms\ProfileForm;
use frontend\forms\RecoverForm;

class UserController extends Controller
{
	/**
	 * Login action.
	 *
	 * @param null|string|array $redirect
	 * @return Response|string
	 */
	public function actionLogin(array $redirect=null)
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$loginForm = new LoginForm();
		if ($loginForm->load(Yii::$app->request->post()) && $loginForm->validate() && User::login($loginForm)) {
			if ($redirect) {
				return $this->redirect($redirect);
			}
			return $this->goBack();
		}
		return $this->render('login', [
			'model' => $loginForm,
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
			return $this->redirect(['user/login', 'redirect' => Url::to(['user/profile'])]);
		}

		$profileForm = new ProfileForm();
		$user = User::currentUser();
		$profileForm->load($user->attributes, '');

		if ($profileForm->load(Yii::$app->request->post()) && $profileForm->validate() && User::updateProfile($profileForm)) {
			Yii::$app->session->setFlash('success');
			return $this->redirect(['user/profile']);
		}

		return $this->render('profile', [
			'profileForm' => $profileForm,
		]);
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

		$registerForm = new RegisterForm();

		if ($registerForm->load(Yii::$app->request->post()) && $registerForm->validate()) {
			$token = Yii::$app->request->post('g-recaptcha-token');
			$action = Yii::$app->request->post('g-recaptcha-action');
			if (Yii::$app->recaptcha->verify($token, $action)) {
				if (User::register($registerForm, true)) {
					Yii::$app->session->setFlash('success');
					return $this->redirect(['user/profile']);
				}
			} else {
				$registerForm->addError('recaptcha', 'Recaptcha error');
			}
		}

		return $this->render('register', [
			'registerForm' => $registerForm,
		]);
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

		$recoverForm = new RecoverForm();

		if ($recoverForm->load(Yii::$app->request->post()) && $recoverForm->validate()) {
			$user = User::findByEmail($recoverForm->email);
			if ($user && $user->sendRecover()) {
				Yii::$app->session->setFlash('success');
				return $this->redirect(['user/recover-password']);
			}
			$recoverForm->addError('email', 'Пользователя с таким E-mail нет в системе');
		}

		return $this->render('recover', [
			'recoverForm' => $recoverForm,
		]);
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
		if (User::resetPassword($token)) {
			Yii::$app->session->setFlash('recover-success');
		} else {
			Yii::$app->session->setFlash('recover-error');
		}
		return $this->redirect(['user/login']);
	}
}