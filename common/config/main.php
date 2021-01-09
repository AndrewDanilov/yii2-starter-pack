<?php
return [
	'language' => 'ru-RU',
	'timeZone' => 'Europe/Moscow',
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
	],
	'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	'components' => [
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'formatter' => [
			'defaultTimeZone' => 'Europe/Moscow',
			'dateFormat'     => 'php:d.m.Y',
			'datetimeFormat' => 'php:d.m.Y H:i:s',
			'timeFormat'     => 'php:H:i:s',
		],
	],
];
