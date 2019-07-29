<?php

/* @var $this yii\web\View */

$this->title = 'Ошибка';

use andrewdanilov\menu\Breadcrumbs;
use common\models\Locality; ?>

<div class="section-main">
	<div class="container">
		<?= Breadcrumbs::widget([
			'homeLabel' => Yii::$app->params['site.breadcrumbsHomeLabel'] . ' ' . Locality::getCurrent()->name2,
			'items' => [
				'Ошибка',
			],
		]); ?>
		<img src="/images/page-not-found.211a85e40c.svg" class="error-image" />
		<h2>Ошибка на странице</h2>
		<div>На странице произошла ошибка. Попробуйте воспользоваться поиском по сайту или начать с главной страницы.</div>
	</div>
</div>
