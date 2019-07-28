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
		'/css/select2.min.css',
		'/css/swiper.min.css',
		'/css/user.custom.css',
		'/css/user.select2.css',
	];
	public $js = [
		'/js/jquery.cookie.js',
		'/js/placeholders.min.js',
		'/js/select2.min.js',
		'/js/swiper.min.js',
		'/js/user.cart.js',
		'/js/user.catalog.js',
		'/js/user.custom.js',
		'/js/user.form.js',
		'/js/user.select2.js',
		'/js/user.slider.js',
	];
	public $depends = [
		'yii\web\JqueryAsset',
	];
}
