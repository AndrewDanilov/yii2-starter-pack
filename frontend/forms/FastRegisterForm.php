<?php
namespace frontend\forms;

class FastRegisterForm extends RegisterForm
{
	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'email'], 'required'],
			[['name', 'email'], 'string', 'max' => 255],
			[['email'], 'email'],
			[['email'], 'validateUniqueEmail'],
		];
	}
}