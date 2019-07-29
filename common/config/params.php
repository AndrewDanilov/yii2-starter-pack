<?php
return [
	'siteName' => 'MySite',

	'adminEmail' => ['admin@example.com', 'manager@example.com'],
	'adminEmailLogin' => 'manager@example.com',
	'adminEmailPwd' => 'password',
	'adminEmailHost' => 'smtp.example.com',
	'adminEmailPort' => '465',
	'adminEmailEncryption' => 'ssl',

	'user.passwordResetTokenExpire' => 3600,
	'user.cookieExpire' => 3600 * 24 * 30,
];
