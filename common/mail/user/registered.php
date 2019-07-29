<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var \frontend\forms\RegisterForm $model */

?>

Вы зарегистрировались на сайте <?= Html::a(Yii::$app->params['siteName'], Url::to(['/'], true)) ?><br />
<br />
Ваше имя: <?= $model->name ?><br />
Ваш e-mail: <?= $model->email ?><br />
Ваш пароль: <?= $model->password ?><br />