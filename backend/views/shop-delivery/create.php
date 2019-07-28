<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopDelivery|\common\behaviors\LangBehavior */

$this->title = 'Новый способ доставки';
$this->params['breadcrumbs'][] = ['label' => 'Способы доставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
