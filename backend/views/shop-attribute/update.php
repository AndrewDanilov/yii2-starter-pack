<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ShopAttribute|\common\behaviors\LangBehavior|\common\behaviors\TagBehavior */

$this->title = 'Изменить атрибут: ' . $model->getLang()->name;
$this->params['breadcrumbs'][] = ['label' => 'Атрибуты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->getLang()->name;
?>
<div class="shop-attribute-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
