<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;

class CartMessage extends Widget
{
	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$cart = [
			'items' => [],
			'count' => 0,
			'summ' => 0,
		];

		$session = Yii::$app->session;
		if ($session->has('cart')) {
			$cart = array_merge($cart, $session['cart']);
		}

		return $this->render('cart/message', ['cart' => $cart]);
	}
}