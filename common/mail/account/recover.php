<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var \common\models\Account $model */

$resetLink = Url::to(['site/reset-password', 'token' => $model->user->password_reset_token], true);

?>

Вы запросили восстановление пароля на сайте <?= Html::a(Yii::$app->params['siteName'], Url::to(['/'], true)) ?><br />
<br />
Для продолжения перейдите по ссылке:<br/>
<?= Html::a(Html::encode($resetLink), $resetLink) ?>