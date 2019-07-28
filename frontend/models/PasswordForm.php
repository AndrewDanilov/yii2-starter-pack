<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * @property $password string
 * @property $password_confirm string
 */
class PasswordForm extends Model
{
	public $password;
	public $password_confirm;
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['password', 'password_confirm'], 'required'],
			[['password', 'password_confirm'], 'string'],
			[['password_confirm'], 'validatePasswordConfirm'],
		];
	}

	/**
	 * Валидатор подтверждения пароля
	 *
	 * @param $attribute
	 */
	public function validatePasswordConfirm($attribute)
	{
		if ($this->password != $this->password_confirm) {
			$this->addError($attribute, Yii::t('site', 'Пароль и подтверждение пароля не совпадают'));
		}
	}
}