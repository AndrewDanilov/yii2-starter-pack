<?php

/* @var $this View */
/* @var $content string */
/* @var $directoryAsset false|string */

use yii\web\View;

?>

<div class="page-top">
	<div class="top-header"><?= $this->title ?></div>
	<div class="profile-panel">
		<div class="profile-item">
			<span class="small"><?= Yii::$app->user->identity['email']; ?></span>
			<span class="user-icon fa fa-user-circle"></span>
		</div>
	</div>
</div>