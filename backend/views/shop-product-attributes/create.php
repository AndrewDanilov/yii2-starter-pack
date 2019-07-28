<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ShopProductAttributes */

$this->title = 'Create Shop Product Attributes';
$this->params['breadcrumbs'][] = ['label' => 'Shop Product Attributes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-product-attributes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
