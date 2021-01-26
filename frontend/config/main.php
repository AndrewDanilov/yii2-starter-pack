<?php
$params = array_merge(
	require __DIR__ . '/../../common/config/params.php',
	require __DIR__ . '/params.php'
);

return [
	'id' => 'app-frontend',
	'basePath' => dirname(__DIR__),
	'controllerNamespace' => 'frontend\controllers',
	'homeUrl' => '/',
	'components' => [
		'request' => [
			'baseUrl' => '',
			'csrfParam' => '_csrf-frontend',
			'class' => 'yii\web\Request'
		],
		'session' => [
			'name' => 'session-id',
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'class' => 'yii\web\UrlManager',
			'enableStrictParsing' => true,
			'rules' => [
				'' => 'site/index',
				'ajax/<action>' => 'ajax/<action>',
				'<action>' => 'site/<action>',
			],
		],
	],
	'params' => $params,
	'bootstrap' => ['log'],
];
