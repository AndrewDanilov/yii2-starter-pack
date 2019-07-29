<?php
namespace backend\controllers;

use Yii;
use yii\web\Response;
use common\forms\LoginForm;
use common\models\User;
use backend\forms\UserSearch;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BackendController
{
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
		$loginForm = new LoginForm();
		if ($loginForm->load(Yii::$app->request->post()) && $loginForm->validate() && User::login($loginForm)) {
			return $this->goBack();
		}
		if (Yii::$app->getSession()->getFlash('error') == 'access-denied') {
			// если попали на страницу логина из-за запрета доступа
			$loginForm->addError('email', 'Access denied for this user.');
		}
		$this->layout = '//login';
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
		return $this->goHome();
	}

	/**
     * @return mixed
     */
    public function actionIndex()
    {
	    $searchModel = new UserSearch();
	    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	    return $this->render('index', [
		    'searchModel' => $searchModel,
		    'dataProvider' => $dataProvider,
	    ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
	    $model = new User();

	    if ($model->load(Yii::$app->request->post()) && $model->save()) {
			return $this->redirect(['index']);
	    }

	    return $this->render('create', [
		    'model' => $model,
	    ]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = User::findOne(['id' => $id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function actionDelete($id)
    {
	    User::findOne(['id' => $id])->delete();

        return $this->redirect(['index']);
    }
}
