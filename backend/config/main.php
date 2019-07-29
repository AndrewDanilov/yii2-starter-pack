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
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				[
					'class' => 'backend\components\UrlRule',
				]
			],
		],
		'frontendCache' => [
			'class' => 'yii\caching\FileCache',
			'cachePath' => Yii::getAlias('@frontend') . '/runtime/cache'
		],
	],
	'controllerMap' => [
		'elfinder' => [
			'class' => 'mihaildev\elfinder\Controller',
			'access' => ['admin'],
			'roots' => [
				[
					'baseUrl' => '',
					'basePath' => '@frontend/web',
					'path' => 'upload/images',
					'name' => 'Изображения',
				],
				[
					'baseUrl' => '',
					'basePath' => '@frontend/web',
					'path' => 'upload/properties',
					'name' => 'Иконки свойств',
				],
				[
					'baseUrl' => '',
					'basePath' => '@frontend/web',
					'path' => 'upload/article-images',
					'name' => 'Фото для статей',
				],
			],
		],
	],
	'modules' => [
		'custompages' => [
			'class' => 'andrewdanilov\custompages\Module',
			'controllerMap' => [
				'category' => [
					'class' => 'andrewdanilov\custompages\controllers\backend\CategoryController',
					// access role for category controller
					'access' => ['admin'],
				],
				'page' => [
					'class' => 'andrewdanilov\custompages\controllers\backend\PageController',
					// access role for page controller
					'access' => ['admin'],
				],
			],
			// path to Views for pages and categories
			'templatesPath' => '@frontend/views/custompages',
		],
	],
	'bootstrap' => ['log'],
	'params' => $params,
];
