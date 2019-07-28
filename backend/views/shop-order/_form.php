<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\ShopPay;
use common\models\ShopDelivery;
use common\models\ShopOrder;

/* @var $this yii\web\View */
/* @var $model common\models\ShopOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-order-form">

    <?php $form = ActiveForm::begin(); ?>

	<div class="form-group">
		<label for="">Создан</label>
		<div>
			<?= $model->created_at; ?>
		</div>
	</div>

	<div class="form-group">
		<label for="">Покупатель</label>
		<div>
			<?= $model->account->getAccountStr(true) ?>
		</div>
	</div>

	<div class="form-group">
		<label for="">Получатель</label>
		<div>
			<?= $model->addresseeStr ?>
		</div>
	</div>

	<div class="form-group">
		<label for="">Адрес доставки</label>
		<div>
			<?= $model->addressStr; ?>
		</div>
	</div>

	<div class="form-group">
		<label for="">Товаров на сумму</label>
		<div>
			<?= $model->summ; ?>
		</div>
	</div>

    <?= $form->field($model, 'pay_id')->dropDownList(ShopPay::getPayList()) ?>

    <?= $form->field($model, 'delivery_id')->dropDownList(ShopDelivery::getDeliveryList()) ?>

    <?= $form->field($model, 'status')->dropDownList(ShopOrder::getStatusList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
