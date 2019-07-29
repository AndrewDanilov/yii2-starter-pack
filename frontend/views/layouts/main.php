<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Spaceless;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta content="<?= Html::encode($this->title) ?>" property="og:title" />
	<meta content="width=device-width, initial-scale=1" name="viewport" />

	<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />

	<meta charset="<?= Yii::$app->charset ?>">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body class="body">
<?php $this->beginBody() ?>
<?php Spaceless::begin() ?>

<?= $content; ?>

<?php Spaceless::end(); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
