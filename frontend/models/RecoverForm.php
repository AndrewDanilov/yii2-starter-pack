<?php

namespace frontend\models;

use yii\base\Model;

/**
 * @property $email string
 */
class RecoverForm extends Model
{
	public $email;
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['email'], 'required'],
			[['email'], 'email'],
		];
	}
}