<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "site_shop_order".
 *
 * @property int $id
 * @property int $account_id
 * @property string $created_at
 * @property string $addressee_name
 * @property string $addressee_email
 * @property string $addressee_phone
 * @property array|string $address
 * @property int $pay_id
 * @property int $delivery_id
 * @property int $status
 * @property ShopProduct[] $products
 * @property ShopOrderProducts[] $orderProducts
 * @property Account $account
 * @property ShopPay $pay
 * @property ShopDelivery $delivery
 * @property string $addressStr
 * @property string $summ
 * @property string $statusStr
 * @property string $addresseeStr
 */
class ShopOrder extends \yii\db\ActiveRecord
{
	const ORDER_STATUS_INIT = 0;
	const ORDER_STATUS_SENT = 1;
	const ORDER_STATUS_DONE = 2;
	const ORDER_STATUS_CANCELED = 10;

	/* @var array $_orderProducts */
	private $_orderProducts = []; // товары для нового создаваемого заказа во внутреннем формате

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			[
				'class' => 'common\behaviors\DateBehavior',
				'dateAttributes' => [
					'created_at' => \common\behaviors\DateBehavior::DATETIME_FORMAT,
				],
			],
		];
	}

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id'], 'required'],
            [['addressee_email'], 'email'],
            [['account_id', 'pay_id', 'delivery_id', 'status'], 'integer'],
            [['created_at', 'address'], 'safe'],
            [['addressee_name', 'addressee_email', 'addressee_phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создан',
            'account_info' => 'Покупатель',
            'addressee' => 'Получатель',
            'addressee_name' => 'Имя получателя',
            'addressee_email' => 'E-mail получателя',
            'addressee_phone' => 'Телефон получателя',
            'address' => 'Адрес доставки',
            'pay_id' => 'Способ оплаты',
            'delivery_id' => 'Способ доставки',
            'status' => 'Статус',
            'summ' => 'Сумма',
        ];
    }

	/**
	 * @return \yii\db\ActiveQuery|Account
	 */
    public function getAccount()
    {
    	return $this->hasOne(Account::class, ['id' => 'account_id']);
    }

    public function getOrderProducts()
    {
    	return $this->hasMany(ShopOrderProducts::class, ['order_id' => 'id']);
    }

    public function getProducts()
    {
    	return $this->hasMany(ShopProduct::class, ['id' => 'product_id'])->via('orderProducts');
    }

    public function getPay()
    {
    	return $this->hasOne(ShopPay::class, ['id' => 'pay_id']);
    }

    public function getDelivery()
    {
    	return $this->hasOne(ShopDelivery::class, ['id' => 'delivery_id']);
    }

    //////////////////////////////////////////////////////////////////

	public function afterFind()
	{
		$this->address = unserialize($this->address);
		if (!is_array($this->address)) {
			$this->address = [];
		}
		parent::afterFind();
	}

	public function beforeSave($insert)
	{
		$this->address = serialize($this->address);
		return parent::beforeSave($insert);
	}

	public function afterSave($insert, $changedAttributes)
	{
		foreach ($this->_orderProducts as $_orderProduct) {
			if (!isset($_orderProduct['product_id'])) {
				$_orderProduct['product_id'] = $_orderProduct['id'];
			}
			$orderProduct = new ShopOrderProducts();
			$orderProduct->load($_orderProduct, '');
			$orderProduct->order_id = $this->id;
			if ($orderProduct->save()) {
				if (isset($_orderProduct['product_options']) && is_array($_orderProduct['product_options'])) {
					$productOptionIds = array_keys($_orderProduct['product_options']);
					$productOptions = ShopProductOptions::find()->where(['id' => $productOptionIds])->all();
					foreach ($productOptions as $productOption) {
						$orderProduct->link('productOptions', $productOption);
					}
				}
			}
		}
		$this->_orderProducts = [];
		$this->address = unserialize($this->address);
		if (!is_array($this->address)) {
			$this->address = [];
		}
		parent::afterSave($insert, $changedAttributes);
	}

	public function beforeDelete()
	{
		foreach ($this->orderProducts as $model) {
			$model->delete();
		}
		return parent::beforeDelete();
	}

	//////////////////////////////////////////////////////////////////

	public static function getStatusList()
	{
		return [
			self::ORDER_STATUS_INIT => 'Создан',
			self::ORDER_STATUS_SENT => 'Отправлен',
			self::ORDER_STATUS_DONE => 'Завершен',
			self::ORDER_STATUS_CANCELED => 'Отменен',
		];
	}

	public function getStatusStr()
	{
		$statusList = static::getStatusList();
		if (isset($statusList[$this->status])) {
			return $statusList[$this->status];
		}
		return '';
	}

	//////////////////////////////////////////////////////////////////

	/**
	 * Последний заказ текущего пользователя
	 *
	 * @return array|ShopOrder|null|\yii\db\ActiveRecord
	 */
	public static function getLastOrder()
	{
		$account = Account::getCurrentUser();
		return static::find()->where(['account_id' => $account->id])->orderBy('id DESC')->limit(1)->one();
	}

	/**
	 * Возвращает данные получателя в виде строки
	 *
	 * @return string
	 */
	public function getAddresseeStr()
	{
		$content = [];
		$content[] = $this->addressee_name;
		$content[] = $this->addressee_email;
		$content[] = $this->addressee_phone;
		return implode('<br/>', $content);
	}

	/**
	 * Возвращает данные адреса в виде строки
	 *
	 * @return string
	 */
	public function getAddressStr()
	{
		return implode(', ', array_filter([
			ArrayHelper::getValue($this->address, 'postindex'),
			ArrayHelper::getValue($this->address, 'city'),
			ArrayHelper::getValue($this->address, 'street') ? 'ул. ' . ArrayHelper::getValue($this->address, 'street') : '',
			ArrayHelper::getValue($this->address, 'house') ? 'д. ' . ArrayHelper::getValue($this->address, 'house') : '',
			ArrayHelper::getValue($this->address, 'block') ? 'корп. ' . ArrayHelper::getValue($this->address, 'block') : '',
			ArrayHelper::getValue($this->address, 'building') ? 'строение ' . ArrayHelper::getValue($this->address, 'building') : '',
			ArrayHelper::getValue($this->address, 'appartment') ? 'кв. ' . ArrayHelper::getValue($this->address, 'appartment') : '',
		]));
	}

	/**
	 * Сумма товаров в заказе
	 *
	 * @return mixed
	 */
	public function getSumm()
	{
		return $this->getOrderProducts()->sum(new Expression('price * count'));
	}

	//////////////////////////////////////////////////////////////////

	/**
	 * Добавляет связи с товарами для нового создаваемого заказа
	 *
	 * @param array $orderProducts
	 */
	public function setOrderProducts($orderProducts)
	{
		$this->_orderProducts = $orderProducts;
	}

	//////////////////////////////////////////////////////////////////

	/**
	 * Sends an email to the webmaster email address using the information collected by this model.
	 *
	 * @return boolean
	 */
	public function sendNotify()
	{
		// формируем письмо
		$mailer = Yii::$app->mailer->compose('order/order-sent', ['model' => $this])
			->setFrom([Yii::$app->params['adminEmailLogin'] => Yii::$app->params['siteName']])
			->setTo(preg_split('/\s*,\s*/', Yii::$app->params['adminEmail']))
			->setSubject('Заказ с сайта');
		// отправляем письмо админу
		if ($mailer->send()) {
			// также отправим письмо пользователю
			if ($this->addressee_email) {
				$mailer->setTo($this->addressee_email);
				$mailer->send();
			}
			return true;
		} else {
			$this->addError('', 'Возникла ошибка на сервере при отправке сообщения');
		}
		return false;
	}
}
