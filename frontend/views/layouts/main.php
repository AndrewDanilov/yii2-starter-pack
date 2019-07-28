<?php

/* @var $this View */
/* @var $content string */

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Spaceless;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="<?= Yii::$app->charset ?>">
	<base href="/">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<?php Spaceless::begin() ?>

<?= $content; ?>

<?php Spaceless::end(); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
