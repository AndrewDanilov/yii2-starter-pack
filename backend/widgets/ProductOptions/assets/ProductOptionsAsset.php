<?php

namespace backend\widgets\ProductOptions\assets;

use yii\web\AssetBundle;

class ProductOptionsAsset extends AssetBundle
{
	public $sourcePath = '@backend/widgets/ProductOptions/src';
	public $css = [
	];
	public $js = [
		'js/product-options.js',
	];
	public $depends = [
		'yii\web\YiiAsset',
		'yii\jui\JuiAsset',
	];
}