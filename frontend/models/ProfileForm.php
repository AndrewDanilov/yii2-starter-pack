<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Account;

/**
 * @property $name string
 * @property $phone string
 * @property $email string
 * @property $organization string
 * @property $inn string
 */
class ProfileForm extends Model
{
	public $name;
	public $phone;
	public $email;
	public $organization;
	public $inn;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'email'], 'required'],
			[['name', 'phone', 'email', 'organization', 'inn'], 'string', 'max' => 255],
			[['email'], 'email'],
			[['email'], 'validateUniqueEmail'],
		];
	}

	/**
	 * Валидатор уникальности емайла
	 *
	 * @param $attribute
	 */
	public function validateUniqueEmail($attribute)
	{
		if (User::find()->where(['email' => $this->$attribute])->andWhere(['not', ['id' => Account::getCurrentUser()->user_id]])->one() !== null) {
			$this->addError($attribute, Yii::t('site', 'Такой e-mail уже зарегистрирован в системе'));
		}
	}
}