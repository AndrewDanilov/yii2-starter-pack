<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use common\models\ShopProduct;
use backend\models\ShopProductSearch;
use backend\widgets\ProductOptions\ProductOptionHtml;

/**
 * ShopProductController implements the CRUD actions for ShopProduct model.
 */
class ShopProductController extends BackendController
{
    /**
     * Lists all ShopProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ShopProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShopProduct();

	    $model->getBehavior('shopAttributes')->optionsFilter = ArrayHelper::map($model->availableAttributes, 'id', 'id');
	    $model->getBehavior('shopOptions')->optionsFilter = ArrayHelper::map($model->availableOptions, 'id', 'id');

	    if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ShopProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

	    $model->getBehavior('shopAttributes')->optionsFilter = ArrayHelper::map($model->availableAttributes, 'id', 'id');
	    $model->getBehavior('shopOptions')->optionsFilter = ArrayHelper::map($model->availableOptions, 'id', 'id');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ShopProduct model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
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
     * Finds the ShopProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShopProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShopProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    //////////////////////////////////////////////////////////////////

	/**
	 * Возвращает html код группы полей для добавления новой опции к товару.
	 *
	 * @param $optionId - ID опции
	 * @return string
	 */
	public function actionOptionGroup($optionId)
	{
		if (Yii::$app->request->isAjax) {
			if (Yii::$app->request->isPost) {

				return ProductOptionHtml::widget(['optionId' => $optionId]);

			}
		}
		throw new BadRequestHttpException("Error request");
	}
}
