<?php
$config = [
	'components' => [
		'db' => [
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=localhost;dbname=dbname',
			'username' => 'username',
			'password' => 'password',
			'charset' => 'utf8',
			'enableSchemaCache' => true,
			'attributes' => [
				PDO::MYSQL_ATTR_INIT_COMMAND => "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));",
			],
		],
		'mailer' => [
			'class' => 'yii\swiftmailer\Mailer',
			'viewPath' => '@common/mail',
			'useFileTransport' => false,
			'transport' => [
				'class' => 'Swift_SmtpTransport',
				'host' => 'smtp.example.com',
				'username' => 'mailbox@example.com',
				'password' => 'mypassword',
				'port' => '465',
				'encryption' => 'ssl',
			],
		],
	],
];

if (YII_ENV_DEV) {
	$config['bootstrap'][] = 'debug';
	$config['modules']['debug'] = [
		'class' => 'yii\debug\Module',
		'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.1.*'],
	];
	$config['bootstrap'][] = 'gii';
	$config['modules']['gii'] = [
		'class' => 'yii\gii\Module',
		'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.1.*'],
	];
}

return $config;