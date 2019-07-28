<?php

use andrewdanilov\menu\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $page \andrewdanilov\custompages\models\Page */

$this->title = $page->meta_title ?: $page->title;
$this->registerMetaTag([
	'name' => 'description',
	'content' => $page->meta_description,
]);
?>

<div class="section">
	<div class="container">

		<?= Breadcrumbs::widget([
			'items' => [
				['label' => 'Статьи', 'url' => ['/custompages/default/category', 'id' => $page->category_id]],
				$page->title,
			],
		]); ?>

		<h1><?= $page->title ?></h1>

		<div class="page-image">
			<img src="<?= $page->image ?>" alt=""/>
		</div>

		<div class="page-text">
			<?= $page->text ?>
		</div>
	</div>
</div>
