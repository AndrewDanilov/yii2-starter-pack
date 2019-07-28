<?php

namespace frontend\widgets;

use yii\base\Widget;
use frontend\helpers\Cart;

class CartInformer extends Widget
{
	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$cart = Cart::getCurrencyCart();
		return $this->render('cart/informer', ['cart' => $cart]);
	}
}