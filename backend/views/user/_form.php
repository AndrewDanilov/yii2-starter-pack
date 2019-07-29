<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<hr style="border-top-color:#d2d6de;">

	<?= $form->field($model, 'email')->textInput() ?>

	<?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->isNewRecord ? '' : 'пароль скрыт']) ?>

	<hr style="border-top-color:#d2d6de;">

	<?= $form->field($model, 'status')->dropDownList($model::getStatusDropdownList()) ?>

	<?= $form->field($model, 'is_admin')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
