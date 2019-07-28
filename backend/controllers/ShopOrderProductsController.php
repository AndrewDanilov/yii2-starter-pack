<?php

namespace backend\controllers;

use common\models\ShopOrder;
use Yii;
use common\models\ShopOrderProducts;
use backend\models\ShopOrderProductsSearch;
use yii\web\NotFoundHttpException;

/**
 * ShopOrderProductsController implements the CRUD actions for ShopOrderProducts model.
 */
class ShopOrderProductsController extends BackendController
{
	/**
	 * Lists all ShopOrderProducts models.
	 *
	 * @param $id
	 * @return mixed
	 */
    public function actionIndex($id)
    {
        $searchModel = new ShopOrderProductsSearch();
	    $searchModel->order_id = $id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing ShopOrderProducts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $orderId = $model->order_id;
	    $model->delete();

        return $this->redirect(['index', 'id' => $orderId]);
    }

    /**
     * Finds the ShopOrderProducts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopOrderProducts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopOrderProducts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
