<?php
$params = array_merge(
	require __DIR__ . '/../../common/config/params.php',
	require __DIR__ . '/params.php'
);

return [
	'id' => 'app-frontend',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'controllerNamespace' => 'frontend\controllers',
	'homeUrl' => '/',
	'components' => [
		'request' => [
			'baseUrl' => '',
			'csrfParam' => '_csrf-frontend',
			'class' => 'yii\web\Request',
		],
		'session' => [
			// this is the name of the session cookie used for login on the frontend
			'name' => 'advanced-frontend',
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'urlManager' => [
			'enablePrettyUrl' => true,
			'enableStrictParsing' => true,
			'showScriptName' => false,
			'class' => 'frontend\components\AppUrlManager',
			'rules' => [
				'' => 'site/index',
				[
					'class' => 'frontend\components\SitemapUrlRule',
				],
				'<action>' => 'site/<action>',
			],
		],
	],
	'params' => $params,
	'modules' => [
		'custompages' => [
			'class' => 'andrewdanilov\custompages\Module',
			// path to Views for pages and categories
			'templatesPath' => '@frontend/views/custompages', // path to pages and categories template views
		],
	],
];
