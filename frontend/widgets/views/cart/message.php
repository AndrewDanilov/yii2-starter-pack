<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $cart array */

?>

<div class="post-cart-add">
	<div class="heading-div">
		<h2 class="cart-add-text"><?= Yii::t('site', 'Товар добавлен в корзину') ?></h2>
	</div>
	<div class="cart-add-subheading-text"><?= Yii::t('site', 'Всего в вашей корзине {n, plural, =0{нет товаров} one{# товар} few{# товара} many{# товаров}}.', ['n' => 99]) ?></div>
	<a href="/basket-1" class="cart-link-text"><?= Yii::t('site', 'Посмотреть') ?></a>
	<div class="wrapper-exit" data-ix="close-add-box">
		<div class="exit-text-blk" data-ix="close-filter-box"></div>
	</div>
	<div class="cart-add-list">
		<div class="cart-line">
			<div class="cart-line-product-img">
				<img src="/images/5bd0c78b68635bbe13467a04_Мезококтейли-Thiotoxin.png" alt="" class="product-img-cart-list" />
			</div>
			<div class="cart-line-product">
				<h2 class="cart-line-name">Ellansé™-M</h2>
				<div class="cart-line-description">2 x 1,0 ml</div>
			</div>
			<div class="cart-line-price">
				<div class="order-summa-full">
					<div>200₽</div>
				</div>
			</div>
		</div>
	</div>
	<div class="wrapper-cart-add-bottom-blk">
		<a href="#" class="cart-add-close-link" data-ix="close-add-box"><?= Yii::t('site', 'Продолжить покупки') ?></a>
		<a href="#" class="cart-add-btn w-button"><?= Yii::t('site', 'Оформить заказ') ?></a>
	</div>
</div>