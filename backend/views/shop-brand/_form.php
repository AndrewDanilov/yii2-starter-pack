<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;
use common\models\Lang;

/* @var $this yii\web\View */
/* @var $model common\models\ShopBrand|\common\behaviors\LangBehavior */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-brand-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'image')->widget(InputFile::class, [
		'language'      => 'ru',
		'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
		'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
		'template'      => '<div>' . Html::img($model->image, ['width' => '200', 'class' => 'preview']) . '</div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
		'options'       => ['class' => 'form-control'],
		'buttonOptions' => ['class' => 'btn btn-default'],
		'multiple'      => false,      // возможность выбора нескольких файлов
	]) ?>
	<?php $this->registerJs("$('#shopbrand-image').on('change', function() { $(this).parents('.form-group').find('img.preview').attr('src', $(this).val()); });"); ?>

	<?php foreach ($model->initLangs() as $lang) { ?>
		<?= $form->field($lang, '[' . $lang->lang_id . ']name')->label('Название ' . Lang::getLangIcon($lang->lang_id)); ?>
	<?php } ?>

	<?php foreach ($model->initLangs() as $lang) { ?>
		<?= $form->field($lang, '[' . $lang->lang_id . ']description')->textarea(['rows' => 6])->label('Описание ' . Lang::getLangIcon($lang->lang_id)); ?>
	<?php } ?>

	<?php foreach ($model->initLangs() as $lang) { ?>
		<?= $form->field($lang, '[' . $lang->lang_id . ']seo_title')->label('SEO-title ' . Lang::getLangIcon($lang->lang_id)); ?>
	<?php } ?>

	<?php foreach ($model->initLangs() as $lang) { ?>
		<?= $form->field($lang, '[' . $lang->lang_id . ']seo_description')->textarea(['rows' => 6])->label('SEO-description ' . Lang::getLangIcon($lang->lang_id)); ?>
	<?php } ?>

	<?= $form->field($model, 'is_favorite')->checkbox() ?>

    <?= $form->field($model, 'order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
