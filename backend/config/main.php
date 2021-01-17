<?php
$params = array_merge(
	require __DIR__ . '/../../common/config/params.php',
	require __DIR__ . '/params.php'
);

return [
	'id' => 'app-backend',
	'basePath' => dirname(__DIR__),
	'controllerNamespace' => 'backend\controllers',
	'homeUrl' => '/admin',
	'components' => [
		'request' => [
			'baseUrl' => '/admin',
			'csrfParam' => '_csrf-backend',
		],
		'session' => [
			'name' => 'session-id',
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'user' => [
			'class' => 'yii\web\User',
			'identityClass' => 'andrewdanilov\adminpanel\models\User',
			'accessChecker' => 'andrewdanilov\adminpanel\AccessChecker',
			'enableAutoLogin' => true,
			'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
			'loginUrl' => ['user/login'],
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [],
		],
		'frontendCache' => [
			'class' => 'yii\caching\FileCache',
			'cachePath' => Yii::getAlias('@frontend') . '/runtime/cache'
		],
	],
	'controllerMap' => [
		'user' => [
			'class' => 'andrewdanilov\adminpanel\controllers\UserController',
		],
		'elfinder' => [
			'class' => 'mihaildev\elfinder\Controller',
			'access' => ['admin'],
			'roots' => [
				[
					'baseUrl' => '',
					'basePath' => __DIR__ . '/../../',
					'path' => '',
					'name' => 'Системные файлы',
				],
			],
		],
	],
	'bootstrap' => ['log'],
	'params' => $params,
];
