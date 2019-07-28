<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var \common\models\Account $model */
/* @var array $data */
?>

Вы зарегистрировались на сайте <?= Html::a(Yii::$app->params['siteName'], Url::to(['/'], true)) ?><br />
<br />
Ваше имя: <?= $model->name ?><br />
Ваш e-mail: <?= $model->email ?><br />
Ваш пароль: <?= $data['password'] ?><br />