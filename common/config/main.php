<?php
$params = array_merge(
	require __DIR__ . '/params.php',
	require __DIR__ . '/params-local.php'
);

return [
	'language' => 'ru',
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
	],
	'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'user' => [
			'class' => 'yii\web\User',
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => true,
			'identityCookie' => ['name' => '_identity-common', 'httpOnly' => true],
			'loginUrl' => ['site/login'],
		],
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
			'defaultRoles' => ['guest'],
		],
		'mailer' => [
			'class' => 'common\components\Mailer',
			'viewPath' => '@common/mail',
			'useFileTransport' => false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
			],
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['info'],
					'categories' => ['debug'],
					'logFile' => '@backend/runtime/logs/debug.log',
					'maxFileSize' => 2048,
					'maxLogFiles' => 20,
				],
			],
		],
		'formatter' => [
			'dateFormat'     => 'php:d.m.Y',
			'datetimeFormat' => 'php:d.m.Y H:i:s',
			'timeFormat'     => 'php:H:i:s',
		],
		'i18n' => [
			'translations' => [
				'*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@common/translates',
					'sourceLanguage' => 'ru',
				],
			],
		],
		'settings' => [
			'class' => 'common\components\Settings',
		],
	],
];
