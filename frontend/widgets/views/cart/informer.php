<?php

use yii\helpers\Url;
use common\models\Lang;

/* @var $this yii\web\View */
/* @var $cart array */

?>

<div data-hover="1" data-delay="0" class="cart-box w-dropdown">
	<div class="cart-drop w-dropdown-toggle">
		<div class="wrapper-cart">
			<a href="#" class="wrapper-cart-div w-inline-block">
				<img src="/images/5bcdd50a76071da2aa13750c_Cart-icon.svg" alt="" class="cart-img" />
				<div class="kolichestvo-v-korzine-text" data-cart-total-count><?= $cart['count'] ?><br />‍</div>
			</a>
		</div>
	</div>
	<nav class="top-dropdown-list-2 w-dropdown-list">
		<div class="container-cart-list">
			<div class="cart-list-div">
				<div class="wrapper-itogo">
					<div class="itogo-text-heading"><?= Yii::t('site', 'Товаров на сумму') ?></div>
					<div class="itogo-summa-text"><span data-cart-total-summ><?= number_format($cart['summ'], 2, '.', ' ') ?></span><?= Lang::getCurrency() ?></div>
				</div>
				<div class="wrapper-cart-list-btn div-block-33">
					<a href="<?= Url::to(['site/basket1']) ?>" class="cart-order-btn w-button"><?= Yii::t('site', 'Перейти в корзину') ?></a>
				</div>
			</div>
		</div>
	</nav>
</div>