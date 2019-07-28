<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopDelivery|\common\behaviors\LangBehavior */

$this->title = 'Изменить способ доставки: ' . $model->getLang()->name;
$this->params['breadcrumbs'][] = ['label' => 'Способы доставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->getLang()->name;
?>
<div class="delivery-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
