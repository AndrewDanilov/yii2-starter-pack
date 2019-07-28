<?php

namespace frontend\helpers;

use Yii;
use common\behaviors\LangBehavior;
use common\models\ShopProductOptions;
use common\models\ShopProduct;
use common\models\Lang;

class Cart
{
	/**
	 * @return array
	 */
	public static function getCart()
	{
		$cart = [
			'items' => [],
			'count' => 0,
			'summ' => 0,
		];

		if (Yii::$app->session->has('cart')) {
			$cart = array_merge($cart, Yii::$app->session->get('cart'));
		}

		return $cart;
	}

	/**
	 * @param $cart
	 */
	public static function setCart($cart)
	{
		Yii::$app->session->set('cart', $cart);
	}

	/**
	 * Возвращает корзину со сконвертированными в текущую валюту ценами и суммой.
	 *
	 * @return array
	 */
	public static function getCurrencyCart()
	{
		$cart = static::getCart();
		$summ = 0;
		foreach ($cart['items'] as $cart_item_key => $cart_item) {
			$cart['items'][$cart_item_key]['old_price'] = Prices::calcInCurrency($cart_item['old_price'], Lang::getCurrencyValue());
			$cart['items'][$cart_item_key]['price'] = Prices::calcInCurrency($cart_item['price'], Lang::getCurrencyValue());
			$summ += $cart['items'][$cart_item_key]['price'] * $cart['items'][$cart_item_key]['count'];
		}
		$cart['summ'] = $summ;
		return $cart;
	}

	/**
	 * @param int $id
	 * @param null|string $product_option_ids
	 * @param int $count
	 * @return array
	 */
	public static function addToCart($id, $product_option_ids=null, $count=1)
	{
		$cart = self::getCart();

		if ($count <= 0) {
			$count = 1;
		}

		$cart_item_key = self::getCartItemKey($id, $product_option_ids);
		if ($product_option_ids) {
			$product_option_ids = explode(',', $product_option_ids);
		} else {
			$product_option_ids = [];
		}

		if (isset($cart['items'][$cart_item_key])) {
			// обновляем количество товара в корзине
			$cart['items'][$cart_item_key]['count'] += $count;
		} else {
			// добавляем новый товар в корзину
			/* @var $product ShopProduct|LangBehavior */
			$product = ShopProduct::find()->where(['id' => $id])->one();
			$cart['items'][$cart_item_key] = [
				'id' => $id,
				'product_option_ids' => implode(',', $product_option_ids),
				'name' => $product->lang->name,
				'image' => $product->image,
				'old_price' => $product->old_price,
				'price' => $product->getPriceWithMargin($product_option_ids),
				'count' => $count,
			];
			foreach ($product_option_ids as $product_option_id) {
				$product_option = ShopProductOptions::find()->where(['id' => $product_option_id])->one();
				if ($product_option) {
					$cart['items'][$cart_item_key]['product_options'][$product_option_id] = [
						'name' => $product_option->option->lang->name,
						'value' => $product_option->lang->value,
					];
				}
			}
		}
		$cart['count'] += $count;
		$cart['summ'] += $cart['items'][$cart_item_key]['price'] * $count;

		self::setCart($cart);
		return $cart;
	}

	/**
	 * @param int $id
	 * @param null|string $product_option_ids
	 * @param int $count
	 * @return array
	 */
	public static function removeFromCart($id, $product_option_ids=null, $count=1)
	{
		$cart = self::getCart();

		$cart_item_key = self::getCartItemKey($id, $product_option_ids);

		if (isset($cart['items'][$cart_item_key])) {
			if ($count <= 0) {
				$count = 1;
			}
			if ($count > $cart['items'][$cart_item_key]['count']) {
				$count = $cart['items'][$cart_item_key]['count'];
			}
			// обновляем количество товара в корзине
			$cart['items'][$cart_item_key]['count'] -= $count;
			$cart['count'] -= $count;
			$cart['summ'] -= $cart['items'][$cart_item_key]['price'] * $count;
			// либо полностью удаляем товар из корзины
			if ($cart['items'][$cart_item_key]['count'] == 0) {
				unset($cart['items'][$cart_item_key]);
				if (count($cart['items']) == 0) {
					$cart['count'] = 0;
					$cart['summ'] = 0;
				}
			}
		}

		self::setCart($cart);
		return $cart;
	}

	/**
	 * Очистка корзины
	 */
	public static function clearCart()
	{
		self::setCart([
			'items' => [],
			'count' => 0,
			'summ' => 0,
		]);
	}

	/**
	 * Возвращает уникальный ключ позиции товара в корзине по его ID и ID's его опций
	 *
	 * @param $id
	 * @param string|array $product_option_ids
	 * @return string
	 */
	private static function getCartItemKey($id, $product_option_ids)
	{
		if (!is_array($product_option_ids)) {
			$product_option_ids = explode(',', $product_option_ids);
		}
		$product_option_ids = array_filter(array_unique($product_option_ids));
		sort($product_option_ids);
		return md5($id . '|' . implode(',', $product_option_ids));
	}
}