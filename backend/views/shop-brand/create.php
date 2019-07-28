<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ShopBrand|\common\behaviors\LangBehavior */

$this->title = 'Новый бренд';
$this->params['breadcrumbs'][] = ['label' => 'Бренды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-brand-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
