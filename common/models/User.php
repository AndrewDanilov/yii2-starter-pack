<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\forms\LoginForm;
use frontend\forms\RegisterForm;
use frontend\forms\FastRegisterForm;
use frontend\forms\ProfileForm;

/**
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property bool $email_confirmed
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $online_at
 * @property bool $is_admin
 * @property string $authKey
 * @property string $statusText
 * @property bool $notify_on
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 10;
    const STATUS_BLOCKED = 20;

	public $password = "";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['email', 'name'], 'required'],
			[['email'], 'validateUniqueEmail'],
			[['email'], 'email'],
			[['email', 'name'], 'string', 'max' => 255],
			[['password'], 'string'],
			[['status'], 'in', 'range' => [static::STATUS_ACTIVE, static::STATUS_BLOCKED]],
			[['status'], 'default', 'value' => static::STATUS_ACTIVE],
			[['notify_on'], 'boolean'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Имя',
			'email' => 'E-mail',
			'status' => 'Состояние',
			'created_at' => 'Создан',
			'updated_at' => 'Изменен',
			'online_at' => 'Онлайн',
			'password' => 'Пароль',
			'is_admin' => 'Админ',
		];
	}

	public function beforeSave($insert) {
		if ($this->password) {
			$this->setPassword($this->password);
		} elseif ($insert) {
			$this->addError('password', 'Пароль не может быть пустым.');
			return false;
		}
		if ($insert) {
			$this->created_at = date('Y-m-d H:i:s');
			$this->notify_on = true;
		} else {
			$this->updated_at = date('Y-m-d H:i:s');
		}
		return parent::beforeSave($insert);
	}

	/**
	 * Validates email uniqueness
	 *
	 * @param $attribute
	 */
	public function validateUniqueEmail($attribute)
	{
		if (static::existsByEmail($this->$attribute, $this->id)) {
			$this->addError($attribute, 'Этот емайл уже занят.');
		}
	}

	/**
	 * Validates password
	 *
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Yii::$app->security->validatePassword($password, $this->password_hash);
	}

	public static function getStatusDropdownList()
	{
		return [
			static::STATUS_BLOCKED => 'Заблокирован',
			static::STATUS_ACTIVE => 'Активен',
		];
	}

	/**
	 * Return text status interpretation
	 *
	 * @return mixed|string
	 */
	public function getStatusText()
	{
		$statuses = static::getStatusDropdownList();
		if (isset($statuses[$this->status])) {
			return $statuses[$this->status];
		}
		return '';
	}

	/**
	 * Check if record with this email exists,
	 * excetpting record with ID $except_id
	 *
	 * @param string $email
	 * @param null|int $except_id
	 * @return bool
	 */
	public static function existsByEmail($email, $except_id=null)
	{
		return static::find()
			->andWhere(['email' => $email])
			->andWhere(['not', ['id' => $except_id]])
			->exists();
	}

	/**
	 * Finds current user
	 *
	 * @return static|null
	 */
	public static function currentUser()
	{
		return static::findById(Yii::$app->user->id);
	}

	/**
	 * Finds user by id
	 *
	 * @param int $id
	 * @return static|null
	 */
	public static function findById($id)
	{
		return static::findOne(['id' => $id, 'status' => static::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by email
	 *
	 * @param string $email
	 * @return static|null
	 */
	public static function findByEmail($email)
	{
		return static::findOne(['email' => $email, 'status' => static::STATUS_ACTIVE]);
	}

	/**
	 * Finds user by password reset token
	 *
	 * @param string $token password reset token
	 * @return static|null
	 */
	public static function findByPasswordResetToken($token)
	{
		if (!static::isPasswordResetTokenValid($token)) {
			return null;
		}

		return static::findOne([
			'password_reset_token' => $token,
			'status' => self::STATUS_ACTIVE,
		]);
	}

	/**
	 * Finds out if password reset token is valid
	 *
	 * @param string $token password reset token
	 * @return bool
	 */
	public static function isPasswordResetTokenValid($token)
	{
		if (empty($token)) {
			return false;
		}

		$timestamp = (int) substr($token, strrpos($token, '_') + 1);
		$expire = Yii::$app->params['user.passwordResetTokenExpire'];

		return $timestamp + $expire >= time();
	}

	/**
	 * Generates password hash from password and sets it to the model.
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password_hash = Yii::$app->security->generatePasswordHash($password);
		$this->generateAuthKey();
	}

	/**
	 * Generates "remember me" authentication key
	 */
	public function generateAuthKey()
	{
		$this->auth_key = Yii::$app->security->generateRandomString();
	}

	/**
	 * Generates new password reset token
	 */
	public function generatePasswordResetToken()
	{
		$this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
	}

	/**
	 * Removes password reset token
	 */
	public function removePasswordResetToken()
	{
		$this->password_reset_token = null;
	}

	/**
	 * @param LoginForm $loginForm
	 * @return bool whether the user is logged in successfully
	 */
	public static function login(LoginForm $loginForm)
	{
		$user = User::findByEmail($loginForm->email);
		return Yii::$app->user->login($user, $loginForm->rememberMe ? Yii::$app->params['user.cookieExpire'] : 0);
	}

	/**
	 * @param ProfileForm $profileForm
	 * @return bool
	 */
	public static function updateProfile(ProfileForm $profileForm)
	{
		$user = User::findByEmail($profileForm->email);
		if ($user->load($profileForm->attributes, '') && $user->save()) {
			return true;
		}
		$profileForm->addErrors($user->errors);
		return false;
	}

	/**
	 * Регистрация пользователя.
	 * При необходимости делает автологин.
	 * Отправляет пользователю уведомление об успешной регистрации.
	 *
	 * @param RegisterForm $registerForm
	 * @param bool $autologin - автоматически войти в аккаунт после регистрации
	 * @return boolean
	 */
	public static function register(RegisterForm $registerForm, $autologin=false)
	{
		$user = new static;
		if ($user->load($registerForm->attributes, '') && $user->save()) {
			// залогиним пользователя, если необходимо
			if ($autologin) {
				Yii::$app->user->login($user, Yii::$app->params['user.cookieExpire']);
			}
			// отправим пользователю уведомление
			static::sendRegisterNotify($registerForm);
			return true;
		}
		$registerForm->addErrors($user->errors);
		return false;
	}

	/**
	 * Быстрая регистрация пользователя.
	 * Генерирует и возвращает новый пароль пользователя.
	 * При необходимости делает автологин.
	 *
	 * @param FastRegisterForm $fastRegisterFrom
	 * @param bool $autologin - автоматически войти в аккаунт после регистрации
	 * @return bool|string
	 */
	public static function fastRegister(FastRegisterForm $fastRegisterFrom, $autologin=false)
	{
		$fastRegisterFrom->password = static::generatePassword();
		$user = new static;
		if ($user->load($fastRegisterFrom->attributes, '') && $user->save()) {
			// залогиним пользователя, если необходимо
			if ($autologin) {
				Yii::$app->user->login($user, Yii::$app->params['user.cookieExpire']);
			}
			// отправим пользователю уведомление
			static::sendRegisterNotify($fastRegisterFrom);
			return true;
		}
		$fastRegisterFrom->addErrors($user->errors);
		return false;
	}

	/**
	 * Отправка уведомления об успешной регистрации.
	 *
	 * @param RegisterForm $registerForm
	 * @return bool
	 */
	public static function sendRegisterNotify(RegisterForm $registerForm)
	{
		// формируем письмо
		$mailer = Yii::$app->mailer->compose('user/registered', ['model' => $registerForm])
			->setFrom([Yii::$app->params['adminEmailLogin'] => Yii::$app->params['siteName']])
			->setTo($registerForm->email)
			->setSubject('Вы зарегистрировались на сайте ' . Yii::$app->params['siteName']);
		// отправляем письмо пользователю
		if ($mailer->send()) {
			return true;
		}
		return false;
	}

	/**
	 * Отправка сообщения для восстановления пароля.
	 *
	 * @return bool
	 */
	public function sendRecover()
	{
		if (!static::isPasswordResetTokenValid($this->password_reset_token)) {
			$this->generatePasswordResetToken();
			if (!$this->save()) {
				return false;
			}
		}

		return Yii::$app->mailer->compose('user/recover', ['user' => $this])
			->setFrom([Yii::$app->params['adminEmailLogin'] => Yii::$app->params['siteName']])
			->setTo($this->email)
			->setSubject('Восстановление пароля на сайте ' . Yii::$app->params['siteName'])
			->send();
	}

	/**
	 * Сброс пароля
	 *
	 * @param string $token
	 * @return bool if password was reset.
	 */
	public static function resetPassword($token)
	{
		$user = static::findByPasswordResetToken($token);

		if ($user) {
			$password = static::generatePassword();
			$user->setPassword($password);
			$user->removePasswordResetToken();

			if ($user->save(false)) {
				return Yii::$app->mailer->compose('user/recovered', ['user' => $user, 'password' => $password])
					->setFrom([Yii::$app->params['adminEmailLogin'] => Yii::$app->params['siteName']])
					->setTo($user->email)
					->setSubject('Пароль на сайте ' . Yii::$app->params['siteName'] . ' восстановлен!')
					->send();
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

	/**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => static::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
