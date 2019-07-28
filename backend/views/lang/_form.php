<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\elfinder\InputFile;

/* @var $this yii\web\View */
/* @var $model common\models\Lang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lang-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'image')->widget(InputFile::class, [
		'language'      => 'ru',
		'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
		'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
		'template'      => '<div>' . Html::img($model->image, ['width' => '40', 'class' => 'preview']) . '</div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
		'options'       => ['class' => 'form-control'],
		'buttonOptions' => ['class' => 'btn btn-default'],
		'multiple'      => false,      // возможность выбора нескольких файлов
	]) ?>
	<?php $this->registerJs("$('#lang-image').on('change', function() { $(this).parents('.form-group').find('img.preview').attr('src', $(this).val()); });"); ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true])->label('Ключ (латиница, например: ru)') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'currency_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_default')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
