<?php

/**
 * Инициализирует необходимые для работы опций скрипты
 */

namespace backend\widgets\ProductOptions;

use backend\widgets\ProductOptions\assets\ProductOptionsAsset;
use yii\base\Widget;

class ProductOptionsInit extends Widget
{
	public function run()
	{
		$view = $this->getView();
		ProductOptionsAsset::register($view);
	}
}