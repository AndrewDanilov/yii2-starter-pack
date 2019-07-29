<?php
namespace frontend\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class AjaxController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function beforeAction($action)
	{
		if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
			Yii::$app->response->format = Response::FORMAT_JSON;
			return parent::beforeAction($action);
		}
		throw new BadRequestHttpException("Error request");
	}
}