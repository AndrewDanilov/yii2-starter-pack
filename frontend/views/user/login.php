<?php

/* @var $this \yii\web\View */
/* @var $model \common\forms\LoginForm */

use yii\helpers\Url;
use andrewdanilov\menu\Breadcrumbs;

$this->title = 'Вход в личный кабинет';
$this->registerMetaTag([
	'name' => 'description',
	'content' => '',
]);

$this->params['breadcrumbs'][] = 'Вход в личный кабинет';

?>
<div class="section">
	<div class="container">
		<?= Breadcrumbs::widget([
			'items' => $this->params['breadcrumbs'],
		]); ?>
		<h1 class="main-header">Вход в личный кабинет</h1>
		<div class="help-form-block w-form">
			<form action="<?= Url::current() ?>" method="post" class="w-clearfix">
				<?php if ($model->hasErrors()) { ?>
					<?php foreach ($model->errors as $error) { ?>
						<div class="form-error"><?= reset($error) ?></div>
					<?php } ?>
				<?php } elseif (Yii::$app->session->hasFlash('recover-error')) { ?>
					<div class="form-error">Не удалось изменить пароль.</div>
				<?php } elseif (Yii::$app->session->hasFlash('recover-success')) { ?>
					<div class="form-success">Новый пароль сохранен. Проверьте почтовый ящик.</div>
				<?php } ?>
				<input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
				<label for="email">Email</label>
				<input type="email" name="LoginForm[email]" value="<?= $model->email ?>" class="text-field w-input" autofocus="" maxlength="256" placeholder="Введите Ваш Email" id="email" required="">
				<label for="password">Пароль</label>
				<input type="password" name="LoginForm[password]" class="text-field w-input" maxlength="256" placeholder="Введите Ваш пароль" id="password" required="">
				<div class="form-checkbox w-checkbox">
					<input type="checkbox" name="LoginForm[rememberMe]" value="1" checked="" class="checkbox ml-20 w-checkbox-input" id="rememberMe">
					<label for="rememberMe" class="w-form-label">
						Запомнить меня на этом компьютере
					</label>
				</div>
				<input type="submit" value="Войти" class="button button-primary w-button">
				<a href="<?= Url::to(['user/recover-password']) ?>" class="form-link-right">Я забыл(а) пароль</a>
			</form>
		</div>
	</div>
</div>
