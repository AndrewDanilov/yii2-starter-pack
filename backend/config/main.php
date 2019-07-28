<?php
$params = array_merge(
	require __DIR__ . '/../../common/config/params.php',
	require __DIR__ . '/params.php'
);

return [
	'id' => 'app-backend',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'controllerNamespace' => 'backend\controllers',
	'homeUrl' => '/admin',
	'components' => [
		'request' => [
			'baseUrl' => '/admin',
			'csrfParam' => '_csrf-backend',
		],
		'session' => [
			// this is the name of the session cookie used for login on the backend
			'name' => 'advanced-backend',
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
	'params' => $params,
	'controllerMap' => [
		'elfinder' => [
			'class' => 'mihaildev\elfinder\Controller',
			'access' => ['admin'],
			'roots' => [
				[
					'baseUrl' => '',
					'basePath' => '@frontend/web',
					'path' => 'upload/images/products',
					'name' => 'Фото товаров',
				],
				[
					'baseUrl' => '',
					'basePath' => '@frontend/web',
					'path' => 'upload/images/categories',
					'name' => 'Обложки категорий',
				],
				[
					'baseUrl' => '',
					'basePath' => '@frontend/web',
					'path' => 'upload/images/langs',
					'name' => 'Языки',
				],
				[
					'baseUrl' => '',
					'basePath' => '@frontend/web',
					'path' => 'upload/docs',
					'name' => 'Документы',
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
];
