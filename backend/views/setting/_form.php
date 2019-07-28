<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\SettingCategory;
use common\models\Lang;

/* @var $this yii\web\View */
/* @var $model common\models\Setting|\common\behaviors\LangBehavior|\common\behaviors\ValueTypeBehavior */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="setting-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'category_id')->dropDownList(SettingCategory::find()->select(['name', 'id'])->orderBy('order')->indexBy('id')->column()) ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true])->label('Параметр (только латиница)') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

	<?php foreach ($model->initLangs() as $lang) { ?>
		<?= $model->formField($form, '[' . $lang->lang_id . ']value', 'Значение ' . Lang::getLangIcon($lang->lang_id), $lang) ?>
	<?php } ?>

	<?= $form->field($model, 'type')->dropDownList($model->getTypeList()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
