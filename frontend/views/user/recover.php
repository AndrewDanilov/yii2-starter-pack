<?php

/* @var $this \yii\web\View */
/* @var $recoverForm \frontend\forms\RecoverForm */

use yii\helpers\Url;
use andrewdanilov\menu\Breadcrumbs;

$this->title = 'Восстановление пароля';
$this->registerMetaTag([
	'name' => 'description',
	'content' => '',
]);

?>
<div class="section-main">
	<div class="container">
		<?= Breadcrumbs::widget([
			'items' => [
				'Восстановление пароля',
			],
		]); ?>
		<h1 class="main-header">Восстановление пароля</h1>
		<div class="help-form-block w-form">
			<?php if (Yii::$app->session->hasFlash('success')) { ?>
				<div class="form-success">Инструкции для восстановления пароля отправлены на Ваш Email.</div>
			<?php } else { ?>
				<form action="<?= Url::current() ?>" method="post" class="w-clearfix">
					<input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
					<label for="email">Email</label>
					<input type="text" name="RecoverForm[email]" class="text-field w-input" autofocus="" maxlength="256" placeholder="Введите Ваш Email" id="email" required="">
					<?php if (isset($recoverForm->errors['email'])) { ?>
						<div class="form-field-error"><?= reset($recoverForm->errors['email']) ?></div>
					<?php } ?>
					<input type="submit" value="Восстановить" class="button button-primary w-button">
					<a href="<?= Url::to(['user/login']) ?>" class="form-link-right">Я вспомнил(а) пароль!</a>
				</form>
			<?php } ?>
		</div>
	</div>
</div>