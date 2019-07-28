<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Account;

/* @var $this yii\web\View */
/* @var $model common\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-account-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

	<hr style="border-top-color:#d2d6de;">

    <?= $form->field($model, 'organization')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inn')->textInput(['maxlength' => true]) ?>

	<hr style="border-top-color:#d2d6de;">

	<?= $form->field($model, 'email')->textInput() ?>

	<?= $form->field($model, 'password')->passwordInput() ?>

	<hr style="border-top-color:#d2d6de;">

	<?= $form->field($model, 'status')->dropDownList($model::getStatusDropdownList()) ?>

	<?= $form->field($model, 'isAdmin')->dropDownList($model::getYesNoDropdownList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
