<?php
namespace common\components;

use Yii;

class Mailer extends \yii\swiftmailer\Mailer
{
	/**
	 * @inheritdoc
	 */
	protected function createTransport(array $config)
	{
		$params = Yii::$app->params;
		$transport = [
			'class' => $config['class'],
			'username' => $params['adminEmailLogin'],
			'password' => $params['adminEmailPwd'],
			'host' => $params['adminEmailHost'],
			'port' => $params['adminEmailPort'],
			'encryption' => $params['adminEmailEncryption'],
		];
		return parent::createTransport($transport);
	}
}