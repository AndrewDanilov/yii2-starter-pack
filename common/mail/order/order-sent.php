<?php

use frontend\helpers\Prices;
use common\models\Lang;

/* @var \common\models\ShopOrder $model */

?>

<?= Yii::t('site', 'Заказ с сайта') ?> <?= Yii::$app->params['sitename'] ?>:<br />
<br />
<?= Yii::t('site', 'Имя') ?>: <?= $model->addressee_name ?><br />
<?= Yii::t('site', 'E-mail') ?>: <?= $model->addressee_email ?><br />
<?= Yii::t('site', 'Телефон') ?>: <?= $model->addressee_phone ?><br />
<?= Yii::t('site', 'Адрес') ?>: <?= $model->addressStr ?><br />
<?= Yii::t('site', 'Способ доставки') ?>: <?= $model->delivery->lang->name ?><br />
<?= Yii::t('site', 'Способ оплаты') ?>: <?= $model->pay->lang->name ?><br />
<?= Yii::t('site', 'Организация') ?>: <?= $model->account->organization ?><br />
<?= Yii::t('site', 'ИНН') ?>: <?= $model->account->inn ?><br />
<br />
<?= Yii::t('site', 'Товары') ?>:<br />
<?php foreach ($model->orderProducts as $orderProduct) { ?>
	<?= $orderProduct->name ?>,
	<?= Prices::calcInCurrency($orderProduct->price, Lang::getCurrencyValue(), true) ?><?= Lang::getCurrency() ?>,
	<?= $orderProduct->count ?> <?= Yii::t('site', 'шт.') ?>,
	<?= $orderProduct->productOptionsStr ?>
<br />
<?php } ?>
<?= Yii::t('site', 'На сумму') ?>: <?= Prices::calcInCurrency($model->summ, Lang::getCurrencyValue(), true) ?><?= Lang::getCurrency() ?>