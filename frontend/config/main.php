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
				'login' => 'user/login',
				'logout' => 'user/logout',
				'register' => 'user/register',
				'profile' => 'user/profile',
				'recover-password' => 'user/recover-password',
				'reset-password' => 'user/reset-password',
				'ajax/<action>' => 'ajax/<action>',
				'<action>' => 'site/<action>',
				'' => 'site/index',
			],
		],
		'recaptcha' => [
			'class' => 'andrewdanilov\grecaptchav3\Recaptcha',
			'sitekey' => '12345678901234567890',
			'secret' => '12345678901234567890',
		],
	],
	'params' => $params,
	'modules' => [
		'custompages' => [
			'class' => 'andrewdanilov\custompages\Module',
			// path to Views for pages and categories
			'templatesPath' => '@frontend/views/custompages',
		],
	],
	'controllerMap' => [
		'upload' => [
			'class' => 'andrewdanilov\InputImages\UploadController',
			'path' => 'upload/tmp', // path to upload images, default is 'upload/images'
		],
	],
	'bootstrap' => ['log'],
];
