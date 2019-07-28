<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SettingCategory */

$this->title = 'Изменить раздел настроек: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Настройки сайта', 'url' => ['setting/index']];
$this->params['breadcrumbs'][] = ['label' => 'Разделы настроек', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="setting-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
