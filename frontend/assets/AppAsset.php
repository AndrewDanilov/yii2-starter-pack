<?php
namespace frontend\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'css/site.css',
	];
	public $js = [
		'js/script.js',
	];
	public $depends = [
		'yii\web\JqueryAsset',
	];
}
