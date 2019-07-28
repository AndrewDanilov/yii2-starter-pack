<?php

namespace backend\controllers;

use Yii;
use common\models\Lang;
use backend\models\LangSearch;
use yii\web\NotFoundHttpException;

/**
 * LangController implements the CRUD actions for Lang model.
 */
class LangController extends BackendController
{
    /**
     * Lists all Lang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Lang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lang();

        if ($model->load(Yii::$app->request->post())) {
	        $default_lang = Lang::getDefaultLang();
	        // если сделали язык дефолтным
	        if ($model->is_default) {
		        // старый дефолтный язык сделаем обычным
		        $default_lang->is_default = 0;
		        $default_lang->save();
	        }

	        if ($model->save()) {
		        return $this->redirect(['index']);
	        }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Lang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
	        $default_lang = Lang::getDefaultLang();
	        // если сделали язык дефолтным
	        if ($model->is_default && $model->id != $default_lang->id) {
	        	// старый дефолтный язык сделаем обычным
	        	$default_lang->is_default = 0;
	        	$default_lang->save();
	        }
	        // если сделали язык обычным
	        if (!$model->is_default && $model->id == $default_lang->id) {
	        	// ищем кандидата для нового дефолтного языка
	        	$default_lang = Lang::find()->where(['not', ['id' => $model->id]])->limit(1)->one();
	        	// если кандидат найден
	        	if ($default_lang) {
	        		// сделаем его дефолтным
			        $default_lang->is_default = 1;
			        $default_lang->save();
		        } else {
	        		// иначе запретим снимать дефолтность с текущего языка
			        $model->is_default = 1;
		        }
	        }

	        if ($model->save()) {
		        return $this->redirect(['index']);
	        }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Lang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
    	$lang = $this->findModel($id);
    	if ($lang->is_default) {
		    Yii::$app->getSession()->setFlash('error', 'Нельзя удалять язык по-умолчанию');
	    } else {
		    $lang->delete();
	    }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Lang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Lang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Lang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
