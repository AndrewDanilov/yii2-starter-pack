<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ShopProductOptions */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-product-options-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'option_id')->textInput() ?>

    <?= $form->field($model, 'product_id')->textInput() ?>

    <?= $form->field($model, 'margin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'margin_type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
