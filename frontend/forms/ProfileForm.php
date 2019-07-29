<?php
namespace frontend\forms;

use Yii;
use yii\base\Model;
use common\models\User;

class ProfileForm extends Model
{
	public $name;
	public $email;
	public $password;
	public $password_confirm;
	public $notify_on;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'email'], 'required'],
			[['name', 'email', 'password', 'password_confirm'], 'string', 'max' => 255],
			[['email'], 'email'],
			[['email'], 'validateUniqueEmail'],
			[['password_confirm'], 'validatePasswordConfirm'],
			[['notify_on'], 'boolean'],
		];
	}

	/**
	 * Валидатор уникальности емайла
	 *
	 * @param $attribute
	 */
	public function validateUniqueEmail($attribute)
	{
		if (User::existsByEmail($this->$attribute, Yii::$app->user->id)) {
			$this->addError($attribute, 'Этот емайл уже занят.');
		}
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
			'notify_on' => 'Получать важные уведомления',
		];
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
}