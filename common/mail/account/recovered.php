<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var \common\models\Account $model */

?>

Ваш пароль на сайте <?= Html::a(Yii::$app->params['siteName'], Url::to(['/'], true)) ?> восстановлен!<br />
<br />
Ваше имя: <?= $model->name ?><br />
Ваш e-mail: <?= $model->email ?><br />
Ваш новый пароль: <?= $model->password ?><br />