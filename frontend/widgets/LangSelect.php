<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use common\models\Lang;

class LangSelect extends Widget
{
	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$currentLang = Lang::getCurrentLang();
		$langs = Lang::find()->where(['not', ['id' => $currentLang->id]])->all();
		$url = Yii::$app->request->getUrl();
		return $this->render('lang/select', [
			'currentLang' => $currentLang,
			'langs' => $langs,
			'url' => $url,
		]);
	}
}