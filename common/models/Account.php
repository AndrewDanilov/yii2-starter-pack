<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "site_account".
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $phone
 * @property string $organization
 * @property string $inn
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property bool $isAdmin
 * @property User $user
 * @property User $userRel
 * @property ShopOrder[] $orders
 */
class Account extends ActiveRecord
{
	const SCENARIO_NEW_USER = 'new_user';

	public $password;

	private static $_account = null;
	private $_user = null;
	private $_isAdmin = null;

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'name'], 'required'],
	        [['email'], 'validateUniqueEmail'],
            [['email', 'name', 'phone', 'organization', 'inn'], 'string', 'max' => 255],
	        [['password'], 'required', 'on' => static::SCENARIO_NEW_USER],
	        [['password'], 'string'],
	        [['status'], 'in', 'range' => [User::STATUS_ACTIVE, User::STATUS_DELETED]],
	        [['status'], 'default', 'value' => User::STATUS_ACTIVE],
            [['isAdmin'], 'boolean'],
            [['isAdmin'], 'default', 'value' => 0],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
	        'email' => 'E-mail',
	        'status' => 'Активен',
	        'created_at' => 'Создан',
	        'password' => 'Новый пароль',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'organization' => 'Организация',
            'inn' => 'ИНН',
	        'isAdmin' => 'Администратор',
        ];
    }

    public function getUserRel()
    {
    	return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getOrders()
    {
    	return $this->hasMany(ShopOrder::class, ['account_id' => 'id']);
    }

	//////////////////////////////////////////////////////////////////

	public function beforeValidate()
	{
		$this->user->username = $this->user->email;
		if ($this->password) {
			$this->user->setPassword($this->password);
			$this->user->generateAuthKey();
		}
		return parent::beforeValidate();
	}

	public function beforeSave($insert)
	{
		if ($this->user->save()) {
			$this->user_id = $this->user->id;
			// роль админа
			$role = Yii::$app->authManager->getRole('admin');
			if ($role) {
				if ($this->isAdmin) {
					if (!Yii::$app->authManager->getAssignment('admin', $this->user_id)) {
						Yii::$app->authManager->assign($role, $this->user_id);
					}
				} else {
					Yii::$app->authManager->revoke($role, $this->user_id);
				}
			}
			return parent::beforeSave($insert);
		}
		return false;
	}

	public function beforeDelete()
	{
		$role = Yii::$app->authManager->getRole('admin');
		if ($role) {
			Yii::$app->authManager->revoke($role, $this->user_id);
		}
		return parent::beforeDelete();
	}

	public function afterDelete()
	{
		$this->unlinkAll('userRel', true);
		parent::afterDelete();
	}

	//////////////////////////////////////////////////////////////////

	public function getUser()
	{
		if ($this->_user === null) {
			if ($this->isNewRecord) {
				$this->_user = new User();
			} else {
				$this->_user = $this->getUserRel()->one();
			}
		}
		return $this->_user;
	}

	public function getIsAdmin()
	{
		if ($this->_isAdmin === null) {
			$this->_isAdmin = Yii::$app->authManager->getAssignment('admin', $this->user_id) !== null;
		}
		return $this->_isAdmin;
	}

	public function setIsAdmin($isAdmin)
	{
		$this->_isAdmin = $isAdmin;
	}

	//////////////////////////////////////////////////////////////////

	public function getEmail()
	{
		return $this->user->email;
	}

	public function setEmail($email)
	{
		$this->user->email = $email;
	}

	public function getStatus()
	{
		return $this->user->status;
	}

	public function setStatus($status)
	{
		$this->user->status = $status;
	}

	public function getCreated_at()
	{
		return $this->user->created_at;
	}

	public function setCreated_at($created_at)
	{
		$this->user->created_at = $created_at;
	}

	public function getUpdated_at()
	{
		return $this->user->updated_at;
	}

	public function setUpdated_at($updated_at)
	{
		$this->user->updated_at = $updated_at;
	}

	//////////////////////////////////////////////////////////////////

	/**
	 * Валидатор уникальности емайла
	 *
	 * @param $attribute
	 */
	public function validateUniqueEmail($attribute)
	{
		if (User::find()->where(['email' => $this->$attribute])->andWhere(['not', ['id' => $this->user_id]])->one() !== null) {
			$this->addError($attribute, Yii::t('site', 'Такой e-mail уже зарегистрирован в системе'));
		}
	}

	//////////////////////////////////////////////////////////////////

	/**
	 * Возвращает модель аккаунта текущего пользователя
	 *
	 * @return Account|null
	 */
	public static function getCurrentUser()
	{
		if (Yii::$app->user->isGuest) {
			self::$_account = null;
		} else {
			if (self::$_account === null) {
				self::$_account = Account::findOne(['user_id' => Yii::$app->user->identity['id']]);
			}
		}
		return self::$_account;
	}

	/**
	 * Возвращает модель аккаунта пользователя по его email
	 *
	 * @param $email
	 * @return Account|null
	 */
	public static function findUser($email)
	{
		$user = User::findOne(['email' => $email, 'status' => User::STATUS_ACTIVE]);
		return Account::findOne(['user_id' => $user->id]);
	}

	/**
	 * Возвращает модель аккаунта пользователя по его reset_token
	 *
	 * @param $token
	 * @return Account|null
	 */
	public static function findUserByResetToken($token)
	{
		$user = User::findByPasswordResetToken($token);
		return Account::findOne(['user_id' => $user->id]);
	}

	//////////////////////////////////////////////////////////////////

	public static function getStatusDropdownList()
	{
		return [
			User::STATUS_DELETED => 'Нет',
			User::STATUS_ACTIVE => 'Да',
		];
	}

	public static function getYesNoDropdownList()
	{
		return [
			0 => 'Нет',
			1 => 'Да',
		];
	}

	public function getAccountStr($useUrl=false)
	{
		$content = [];
		if ($useUrl) {
			$content[] = Html::a($this->name, Url::to(['account/update', 'id' => $this->id]));
		} else {
			$content[] = $this->name;
		}
		$content[] = $this->user->email;
		$content[] = $this->phone;
		return implode('<br/>', $content);
	}

	//////////////////////////////////////////////////////////////////

	/**
	 * Быстрая регистрация пользователя из данных, переданных в масиве $data.
	 * Генерирует и возвращает новый пароль пользователя. При необходимости
	 * делает активацию и автологин.
	 *
	 * @param $data
	 * @param bool $activate - автоматически активировать аккаунт после регистрации
	 * @param bool $autologin - автоматически войти в аккаунт после регистрации
	 * @return bool|string
	 */
	public static function fastRegister($data, $activate=false, $autologin=false)
	{
		if (!isset($data['password'])) {
			$data['password'] = static::generatePassword();
		}
		$account = static::register($data, $activate, $autologin);
		if ($account->hasErrors()) {
			return false;
		}
		return $data['password'];
	}

	/**
	 * Регистрация пользователя из данных, переданных в масиве $data.
	 * При необходимости делает активацию и автологин.
	 * Возвращает модель аккаунта.
	 *
	 * @param $data
	 * @param bool $activate - автоматически активировать аккаунт после регистрации
	 * @param bool $autologin - автоматически войти в аккаунт после регистрации
	 * @return Account
	 */
	public static function register($data, $activate=false, $autologin=false)
	{
		$account = new static();
		$account->load($data, '');
		$account->isAdmin = false;
		if ($activate) {
			$account->status = User::STATUS_ACTIVE;
		} else {
			$account->status = null;
		}
		if ($account->save()) {
			if ($activate && $autologin) {
				Yii::$app->user->login($account->user);
			}
			// отправим пользователю уведомление
			$account->sendRegisterNotify($data);
		}
		return $account;
	}

	/**
	 * Отправка уведомления об успешной регистрации
	 *
	 * @param $data
	 * @return bool
	 */
	public function sendRegisterNotify($data)
	{
		// формируем письмо
		$mailer = Yii::$app->mailer->compose('account/registered', ['model' => $this, 'data' => $data])
			->setFrom([Yii::$app->params['adminEmailLogin'] => Yii::$app->params['siteName']])
			->setTo($this->email)
			->setSubject('Вы зарегистрировались на сайте ' . Yii::$app->params['siteName']);
		// отправляем письмо пользователю
		if ($mailer->send()) {
			return true;
		} else {
			$this->addError('', 'Возникла ошибка на сервере при отправке сообщения');
		}
		return false;
	}

	/**
	 * Отправка сообщения для восстановления пароля
	 *
	 * @return bool
	 */
	public function sendRecover()
	{
		if (!User::isPasswordResetTokenValid($this->user->password_reset_token)) {
			$this->user->generatePasswordResetToken();
			if (!$this->user->save()) {
				return false;
			}
		}

		// формируем письмо
		$mailer = Yii::$app->mailer->compose('account/recover', ['model' => $this])
			->setFrom([Yii::$app->params['adminEmailLogin'] => Yii::$app->params['siteName']])
			->setTo($this->email)
			->setSubject('Восстановление пароля на сайте ' . Yii::$app->params['siteName']);
		// отправляем письмо пользователю
		if ($mailer->send()) {
			return true;
		} else {
			$this->addError('', 'Возникла ошибка на сервере при отправке сообщения');
		}
		return false;
	}

	/**
	 * Resets password.
	 *
	 * @return bool if password was reset.
	 */
	public function resetPassword()
	{
		$this->user->removePasswordResetToken();
		$this->password = static::generatePassword();

		if ($this->save()) {
			// формируем письмо
			$mailer = Yii::$app->mailer->compose('account/recovered', ['model' => $this])
				->setFrom([Yii::$app->params['adminEmailLogin'] => Yii::$app->params['siteName']])
				->setTo($this->email)
				->setSubject('Пароль на сайте ' . Yii::$app->params['siteName'] . ' восстановлен!');
			// отправляем письмо пользователю
			if ($mailer->send()) {
				return true;
			} else {
				$this->addError('', 'Возникла ошибка на сервере при отправке сообщения');
			}
		}
		return false;
	}

	/**
	 * Создает случайный пароль
	 *
	 * @return string
	 */
	public static function generatePassword()
	{
		return bin2hex(openssl_random_pseudo_bytes(4));
	}
}
