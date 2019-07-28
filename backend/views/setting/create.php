<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Setting|\common\behaviors\LangBehavior|\common\behaviors\ValueTypeBehavior */

$this->title = 'Новый параметр';
$this->params['breadcrumbs'][] = ['label' => 'Настройки сайта', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
