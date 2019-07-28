<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class FancyboxAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css',
	];
	public $js = [
		'https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js',
	];
	public $depends = [
		'yii\web\JqueryAsset',
	];

}