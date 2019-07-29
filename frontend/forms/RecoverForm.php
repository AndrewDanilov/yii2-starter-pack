<?php
namespace frontend\forms;

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

	/**
	 * {@inheritDoc}
	 */
	public function attributeLabels()
	{
		return [
			'email' => 'Email',
		];
	}
}