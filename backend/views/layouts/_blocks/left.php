<?php

use andrewdanilov\adminpanel\Menu;

/* @var $this \yii\web\View */
/* @var $siteName string */
/* @var $directoryAsset false|string */

$dashboard = [
	['label' => 'Dashboard', 'url' => ['/site/index'], 'icon' => 'tachometer-alt'],
];
$custompages = [
	['label' => 'Страницы'],
	['label' => 'Категории', 'url' => ['/custompages/category'], 'icon' => 'tag'],
];
foreach (\andrewdanilov\custompages\models\Category::getCategoriesList() as $category_id => $category_name) {
	$custompages[] = ['label' => $category_name, 'url' => ['/custompages/page', 'PageSearch' => ['category_id' => $category_id]], 'icon' => 'file'];
}
$system = [
	['label' => 'Система'],
	['label' => 'Пользователи', 'url' => ['/user/index'], 'icon' => 'users'],
	['label' => 'Очистить кэш', 'url' => ['/site/clear-cache'], 'icon' => 'sync-alt'],
];
$items = array_merge($dashboard, [], $custompages, [], $system);
?>

<div class="page-left">
	<div class="sidebar-heading"><?= $siteName ?></div>
	<?= Menu::widget(['items' => $items]) ?>
</div>
