<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * @property $name string
 * @property $email string
 * @property $password string
 * @property $password_confirm string
 */
class RegisterForm extends Model
{
	public $name;
	public $email;
	public $password;
	public $password_confirm;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'email', 'password', 'password_confirm'], 'required'],
			[['name'], 'string'],
			[['email'], 'email'],
			[['email'], 'validateUniqueEmail'],
			[['password_confirm'], 'validatePasswordConfirm'],
		];
	}

	/**
	 * Валидатор уникальности емайла
	 *
	 * @param $attribute
	 */
	public function validateUniqueEmail($attribute)
	{
		if (User::find()->where(['email' => $this->$attribute])->one() !== null) {
			$this->addError($attribute, Yii::t('site', 'Такой e-mail уже зарегистрирован в системе'));
		}
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