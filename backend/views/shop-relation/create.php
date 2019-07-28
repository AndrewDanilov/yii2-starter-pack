<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopRelation */

$this->title = 'Новая связь';
$this->params['breadcrumbs'][] = ['label' => 'Связи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-relation-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
