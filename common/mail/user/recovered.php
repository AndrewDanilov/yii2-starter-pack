<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var \common\models\User $user */
/* @var string $password */

?>

Ваш пароль на сайте <?= Html::a(Yii::$app->params['siteName'], Url::to(['/'], true)) ?> восстановлен!<br />
<br />
Ваше имя: <?= $user->name ?><br />
Ваш e-mail: <?= $user->email ?><br />
Ваш новый пароль: <?= $password ?><br />