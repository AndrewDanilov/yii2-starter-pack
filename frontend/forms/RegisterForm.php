<?php
namespace frontend\forms;

use yii\base\Model;
use common\models\User;

class RegisterForm extends Model
{
	public $name;
	public $email;
	public $password;
	public $password_confirm;
	public $policy_read;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'email', 'password', 'password_confirm'], 'required'],
			[['name', 'email', 'password', 'password_confirm'], 'string', 'max' => 255],
			[['email'], 'email'],
			[['email'], 'validateUniqueEmail'],
			[['password_confirm'], 'validatePasswordConfirm'],
			[['policy_read'], 'validatePolicyRead', 'skipOnEmpty' => false],
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function attributeLabels()
	{
		return [
			'name' => 'Имя',
			'email' => 'Email',
			'password' => 'Пароль',
			'password_confirm' => 'Подтверждение пароля',
		];
	}

	/**
	 * Валидатор уникальности емайла
	 *
	 * @param $attribute
	 */
	public function validateUniqueEmail($attribute)
	{
		if (User::existsByEmail($this->$attribute)) {
			$this->addError($attribute, 'Этот емайл уже занят.');
		}
	}

	/**
	 * Валидатор подтверждения пароля
	 *
	 * @param $attribute
	 */
	public function validatePasswordConfirm($attribute)
	{
		if ($this->password !== $this->password_confirm) {
			$this->addError($attribute, 'Пароль и подтверждение пароля должны совпадать.');
		}
	}

	/**
	 * Валидатор согласия с политикой конфиденциальности
	 *
	 * @param $attribute
	 */
	public function validatePolicyRead($attribute)
	{
		if (!$this->$attribute) {
			$this->addError($attribute, 'Необходимо согласиться с политикой конфиденциальности.');
		}
	}
}