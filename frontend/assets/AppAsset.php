<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'/css/jquery.fancybox.min.css',
		'/css/jquery.mmenu.all.css',
		'/css/select2.min.css',
		'/css/swiper.min.css',
		'/css/user.select2.css',
		'/css/user.custom.css',
	];
	public $js = [
		'/js/jquery.fancybox.min.js',
		'/js/jquery.mmenu.all.js',
		'/js/placeholders.min.js',
		'/js/select2.min.js',
		'/js/swiper.min.js',
		'/js/user.menu.js',
		'/js/user.select2.js',
		'/js/user.slider.js',
		'/js/user.custom.js',
	];
	public $depends = [
		'yii\web\JqueryAsset',
		'rmrevin\yii\fontawesome\AssetBundle',
	];
}
