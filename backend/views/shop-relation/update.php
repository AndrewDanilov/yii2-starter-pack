<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopRelation */

$this->title = 'Изменить связь: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Связи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="shop-relation-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
