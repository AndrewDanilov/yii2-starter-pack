<?php
return [
	'siteName' => 'My App',
	'adminEmail' => 'admin@example.com, webmaster@example.com',
	'adminEmailLogin' => 'admin@example.com',
	'adminEmailPwd' => 'password',
	'adminEmailHost' => 'smtp.yandex.ru',
	'adminEmailPort' => '465',
	'adminEmailEncryption' => 'ssl',
	'user.passwordResetTokenExpire' => 3600,
	// Заполните возможные метки передаваемые в письме,
	// и соответствующие им шаблоны писем (каждый шаблон
	// должен находиться в папке common/mail)
	'sendMailMarks' => [
		'top' => [
			'name' => 'Кнопка в шапке страницы',
			'subject' => 'Письмо с сайта',
			'template' => 'feedback/default',
		],
		'footer' => [
			'name' => 'Кнопка в подвале страницы',
			'subject' => 'Письмо с сайта',
			'template' => 'feedback/default',
		],
		'default' => [
			'name' => '',
			'subject' => 'Письмо с сайта',
			'template' => 'feedback/default',
		],
	],
];
