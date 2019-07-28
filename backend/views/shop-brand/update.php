<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopBrand|\common\behaviors\LangBehavior */

$this->title = 'Изменить бренд: ' . $model->getLang()->name;
$this->params['breadcrumbs'][] = ['label' => 'Бренды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->getLang()->name;
?>
<div class="shop-brand-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
