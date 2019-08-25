<?php

use andrewdanilov\menu\Breadcrumbs;

/* @var $this yii\web\View */

$this->title = 'Ошибка';
?>

<div class="section">
	<div class="container">
		<?= Breadcrumbs::widget([
			'items' => [
				'Ошибка',
			],
		]); ?>
		<h1>Ошибка на странице</h1>
		<div>На странице произошла ошибка. Попробуйте воспользоваться поиском по сайту или начать с главной страницы.</div>
	</div>
</div>
