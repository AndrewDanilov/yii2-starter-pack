<?php

/* @var $this \yii\web\View */
/* @var $profileForm \frontend\forms\ProfileForm */

use yii\helpers\Url;
use andrewdanilov\menu\Breadcrumbs;

$this->title = 'Личный кабинет';
$this->registerMetaTag([
	'name' => 'description',
	'content' => '',
]);

$this->params['breadcrumbs'][] = 'Личный кабинет';

?>
<div class="section">
	<div class="container">
		<?= Breadcrumbs::widget([
			'items' => $this->params['breadcrumbs'],
		]); ?>
		<h1 class="main-header">Личный кабинет</h1>
		<div class="help-form-block w-form">
			<?php if (Yii::$app->session->hasFlash('success')) { ?>
				<div class="form-success">Профиль сохранен.</div>
			<?php } ?>
			<form action="<?= Url::current() ?>" method="post" class="w-clearfix">
				<input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
				<label for="name">Имя</label>
				<input type="text" name="ProfileForm[name]" value="<?= $profileForm->name ?>" class="text-field w-input" autofocus="" maxlength="256" placeholder="Введите Ваше имя" id="name" required="">
				<?php if (isset($profileForm->errors['name'])) { ?>
					<div class="form-field-error"><?= reset($profileForm->errors['name']) ?></div>
				<?php } ?>
				<label for="email">Email</label>
				<input type="email" name="ProfileForm[email]" value="<?= $profileForm->email ?>" class="text-field w-input" maxlength="256" placeholder="Введите Ваш Email" id="email" required="">
				<?php if (isset($profileForm->errors['email'])) { ?>
					<div class="form-field-error"><?= reset($profileForm->errors['email']) ?></div>
				<?php } ?>
				<div class="form-checkbox w-checkbox">
					<input type="hidden" name="ProfileForm[notify_on]" value="0">
					<input type="checkbox" name="ProfileForm[notify_on]" value="1" <?php if ($profileForm->notify_on) { ?>checked=""<?php } ?> class="checkbox ml-20 w-checkbox-input" id="notify_on">
					<label for="notify_on" class="w-form-label">
						Получать важные уведомления
					</label>
				</div>
				<div class="form-divider"></div>
				<label for="new-password">Пароль (только если хотите изменить)</label>
				<input type="password" name="ProfileForm[password]" class="text-field w-input" maxlength="256" placeholder="Введите новый пароль" id="new-password">
				<label for="new-password-confirm">Повторите пароль</label>
				<input type="password" name="ProfileForm[password_confirm]" class="text-field w-input" maxlength="256" placeholder="Повторите новый пароль" id="new-password-confirm">
				<?php if (isset($profileForm->errors['password_confirm'])) { ?>
					<div class="form-field-error"><?= reset($profileForm->errors['password_confirm']) ?></div>
				<?php } ?>
				<div class="form-divider"></div>
				<input type="submit" value="Сохранить" class="button button-primary w-button">
				<a href="<?= Url::to(['user/logout']) ?>" class="form-link-right">Выход</a>
			</form>
		</div>
	</div>
</div>
