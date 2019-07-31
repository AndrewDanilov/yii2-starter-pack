<?php

/* @var $this \yii\web\View */
/* @var $registerForm \frontend\forms\RegisterForm */

use yii\helpers\Url;
use andrewdanilov\menu\Breadcrumbs;

$this->title = 'Регистрация';
$this->registerMetaTag([
	'name' => 'description',
	'content' => '',
]);

$this->params['breadcrumbs'][] = 'Регистрация';

?>
<div class="section">
	<div class="container">
		<?= Breadcrumbs::widget([
			'items' => $this->params['breadcrumbs'],
			'showHome' => true,
		]); ?>
		<h1 class="main-header">Регистрация</h1>
		<div class="help-form-block w-form">
			<form action="<?= Url::current() ?>" id="registerForm" method="post" class="w-clearfix">
				<input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
				<label for="name">Имя</label>
				<input type="text" name="RegisterForm[name]" value="<?= $registerForm->name ?>" class="text-field w-input" autofocus="" maxlength="256" placeholder="Введите Ваше имя" id="name" required="">
				<?php if (isset($registerForm->errors['name'])) { ?>
					<div class="form-field-error"><?= reset($registerForm->errors['name']) ?></div>
				<?php } ?>
				<label for="email">Email</label>
				<input type="email" name="RegisterForm[email]" value="<?= $registerForm->email ?>" class="text-field w-input" maxlength="256" placeholder="Введите Ваш Email" id="email" required="">
				<?php if (isset($registerForm->errors['email'])) { ?>
					<div class="form-field-error"><?= reset($registerForm->errors['email']) ?></div>
				<?php } ?>
				<label for="password">Пароль</label>
				<input type="password" name="RegisterForm[password]" class="text-field w-input" maxlength="256" placeholder="Придумайте пароль" id="password" required="">
				<?php if (isset($registerForm->errors['password'])) { ?>
					<div class="form-field-error"><?= reset($registerForm->errors['password']) ?></div>
				<?php } ?>
				<label for="password-confirm" id="new-password">Повторите пароль</label>
				<input type="password" name="RegisterForm[password_confirm]" class="text-field w-input" maxlength="256" placeholder="Повторите пароль" id="password-confirm" required="">
				<?php if (isset($registerForm->errors['password_confirm'])) { ?>
					<div class="form-field-error"><?= reset($registerForm->errors['password_confirm']) ?></div>
				<?php } ?>
				<div class="form-divider"></div>
				<div class="form-checkbox w-checkbox">
					<input type="checkbox" name="RegisterForm[policy_read]" value="1" <?php if ($registerForm->policy_read) { ?>checked=""<?php } ?> class="checkbox ml-20 w-checkbox-input" required="" id="policy">
					<label for="policy" class="w-form-label">
						Я прочитал(а) и согласен(на) с <a href="<?= Url::to(['site/policy']) ?>" target="_blank">политикой конфиденциальности</a> сайта.
					</label>
				</div>
				<?php if (isset($registerForm->errors['policy_read'])) { ?>
					<div class="form-field-error"><?= reset($registerForm->errors['policy_read']) ?></div>
				<?php } ?>
				<div class="form-divider"></div>
				<input type="submit" value="Зарегистрироваться" class="button button-primary w-button">
				<a href="<?= Url::to(['user/login']) ?>" class="form-link-right">Я уже зарегистрирован(а)</a>
			</form>
		</div>
	</div>
</div>

<?= \andrewdanilov\grecaptchav3\RecaptchaInit::widget([
	'formID' => 'registerForm',
]) ?>