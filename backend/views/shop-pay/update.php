<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopPay|\common\behaviors\LangBehavior */

$this->title = 'Изменить способ оплаты: ' . $model->getLang()->name;
$this->params['breadcrumbs'][] = ['label' => 'Способы оплаты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->getLang()->name;
?>
<div class="pay-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
