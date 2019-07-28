<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopOrder */

$this->title = 'Изменить заказ №' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Заказ №' . $model->id;
?>
<div class="shop-order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
