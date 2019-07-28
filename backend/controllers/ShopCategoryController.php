<?php

namespace backend\controllers;

use Yii;
use common\models\ShopCategory;
use backend\models\ShopCategorySearch;
use yii\web\NotFoundHttpException;

/**
 * ShopCategoryController implements the CRUD actions for ShopCategory model.
 */
class ShopCategoryController extends BackendController
{
    /**
     * Lists all ShopCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ShopCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopCategory();

	    if ($model->load(Yii::$app->request->post()) && $model->save()) {
		    return $this->redirect(['index']);
	    }

	    return $this->render('create', [
		    'model' => $model,
	    ]);
    }

    /**
     * Updates an existing ShopCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
	    $model = $this->findModel($id);

	    if ($model->load(Yii::$app->request->post()) && $model->save()) {
		    return $this->redirect(['index']);
	    }

	    return $this->render('update', [
		    'model' => $model,
	    ]);
    }

	/**
	 * Deletes an existing ShopCategory model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 *
	 * @param integer $id
	 * @return mixed
	 * @throws NotFoundHttpException if the model cannot be found
	 */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShopCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
