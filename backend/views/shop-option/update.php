<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopOption|\common\behaviors\LangBehavior */

$this->title = 'Изменить опцию: ' . $model->getLang()->name;
$this->params['breadcrumbs'][] = ['label' => 'Опции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->getLang()->name;
?>
<div class="shop-option-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
