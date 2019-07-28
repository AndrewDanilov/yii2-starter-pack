<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use sadovojav\ckeditor\CKEditor;
use common\models\Lang;
use common\helpers\CKEditorHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ShopDelivery|\common\behaviors\LangBehavior */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-form">

    <?php $form = ActiveForm::begin(); ?>

	<?php foreach ($model->initLangs() as $lang) { ?>
		<?= $form->field($lang, '[' . $lang->lang_id . ']name')->label('Название ' . Lang::getLangIcon($lang->lang_id)); ?>
	<?php } ?>

	<?php foreach ($model->initLangs() as $lang) { ?>
		<?= $form->field($lang, '[' . $lang->lang_id . ']description')->widget(CKEditor::class, [
			'editorOptions' => CKEditorHelper::defaultOptions(),
		])->label('Описание ' . Lang::getLangIcon($lang->lang_id)); ?>
	<?php } ?>

	<?= $form->field($model, 'order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
