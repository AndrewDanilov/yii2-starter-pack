<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopOption|\common\behaviors\LangBehavior */

$this->title = 'Новая опция';
$this->params['breadcrumbs'][] = ['label' => 'Опции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-option-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
