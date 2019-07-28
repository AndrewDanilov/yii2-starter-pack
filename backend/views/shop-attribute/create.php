<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ShopAttribute|\common\behaviors\LangBehavior|\common\behaviors\TagBehavior */

$this->title = 'Новый атрибут';
$this->params['breadcrumbs'][] = ['label' => 'Атрибуты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-attribute-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
