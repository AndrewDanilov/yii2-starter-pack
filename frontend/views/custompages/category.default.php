<?php

use andrewdanilov\menu\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $category \andrewdanilov\custompages\models\Category */
/* @var $pages \andrewdanilov\custompages\models\Page[] */

$this->title = $category->meta_title ?: $category->title;
$this->registerMetaTag([
	'name' => 'description',
	'content' => $category->meta_description,
]);
?>

<div class="section">
	<div class="container">

		<?= Breadcrumbs::widget([
			'items' => [
				'Статьи',
			],
		]); ?>

		<h1><?= $category->title ?></h1>

		<div class="category-text">

			<?= $category->text ?>

		</div>

		<div class="category-list">

			<?php foreach ($pages as $page) { ?>

				<a class="category-list-item" href="<?= \yii\helpers\Url::to(['default/page', 'id' => $page->id]) ?>">

					<div class="list-item-image">
						<img src="<?= $page->image ?>" alt="">
					</div>
					<div class="list-item-content">
						<div class="list-item-title"><?= $page->title ?></div>
						<div class="list-item-body">
							<?= $page->shortText ?>
						</div>
					</div>

				</a>

			<?php } ?>

		</div>
	</div>
</div>
