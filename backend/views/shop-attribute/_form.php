<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Lang;
use common\models\ShopCategory;

/* @var $this yii\web\View */
/* @var $model common\models\ShopAttribute|\common\behaviors\LangBehavior|\common\behaviors\TagBehavior|\common\behaviors\ValueTypeBehavior */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-attribute-form">

    <?php $form = ActiveForm::begin(); ?>

	<?php foreach ($model->initLangs() as $lang) { ?>
		<?= $form->field($lang, '[' . $lang->lang_id . ']name')->label('Название ' . Lang::getLangIcon($lang->lang_id)); ?>
	<?php } ?>

	<?= $form->field($model, 'type')->dropDownList($model->getTypeList()) ?>

	<?= $form->field($model, 'tagIds')->checkboxList((new ShopCategory())->getFieldItemsTranslatedList('name')) ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
