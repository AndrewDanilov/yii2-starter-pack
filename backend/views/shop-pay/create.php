<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ShopPay|\common\behaviors\LangBehavior */

$this->title = 'Новый способ оплаты';
$this->params['breadcrumbs'][] = ['label' => 'Способы оплаты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
