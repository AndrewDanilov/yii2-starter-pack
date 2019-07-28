<?php

/* @var $this \yii\web\View */
/* @var $currentLang \common\models\Lang */
/* @var $langs \common\models\Lang[] */
/* @var $url string */

?>

<div class="wrapper-language-dropdown">
	<div data-delay="0" class="lang-drop w-dropdown">
		<div class="lang-toggle w-dropdown-toggle" data-ix="dropdown-icon-2">
			<img src="<?= $currentLang->image ?>" alt="" class="flag-icon-img" />
			<div class="icon w-icon-dropdown-toggle"></div>
			<div class="lang-text"><?= $currentLang->name ?></div>
		</div>
		<nav class="lang-list w-dropdown-list">
			<?php foreach ($langs as $lang) { ?>
				<a href="<?= ($lang->is_default ? '' : '/' . $lang->key) . $url ?>" class="lang-link w-dropdown-link"><?= $lang->name ?></a>
			<?php } ?>
		</nav>
	</div>
</div>
