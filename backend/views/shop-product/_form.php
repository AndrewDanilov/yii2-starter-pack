<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use andrewdanilov\InputImages\InputImages;
use backend\widgets\ProductOptions\ProductOptionsInit;
use backend\widgets\ProductOptions\ProductOptionHtml;
use common\models\ShopBrand;
use common\models\Lang;
use common\helpers\NestedCategoryHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ShopProduct|\common\behaviors\LangBehavior|\common\behaviors\ShopOptionBehavior */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-product-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'article')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'images')->widget(InputImages::class, ['multiple' => true]) ?>

	<?php foreach ($model->initLangs() as $lang) { ?>
		<?= $form->field($lang, '[' . $lang->lang_id . ']name')->label('Название ' . Lang::getLangIcon($lang->lang_id)); ?>
	<?php } ?>

	<?php foreach ($model->initLangs() as $lang) { ?>
		<?= $form->field($lang, '[' . $lang->lang_id . ']description')->textarea(['rows' => 6])->label('Описание ' . Lang::getLangIcon($lang->lang_id)); ?>
	<?php } ?>

	<?= $form->field($model, 'brand_id')->dropDownList((new ShopBrand())->getFieldItemsTranslatedList('name')) ?>

	<?= $form->field($model, 'tagIds')->checkboxList(NestedCategoryHelper::getDropdownTree(), ['class' => 'form-scroll-group']) ?>

    <?= $form->field($model, 'old_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_popular')->checkbox() ?>

	<?php /* @var \common\behaviors\ShopOptionBehavior $options */ ?>
	<?php $options = $model->getBehavior('shopAttributes') ?>
	<?php foreach ($options->initOptions() as $option) { ?>
		<?php /* @var \common\models\ShopAttribute|\common\behaviors\LangBehavior $shopOption */ ?>
		<?php $shopOption = $option['option'] ?>
		<?php /* @var \common\models\ShopProductAttributes[]|\common\behaviors\LangBehavior[] $shopProductOptions */ ?>
		<?php $shopProductOptions = $option['items'] ?>
		<?php /* @var \common\models\ShopAttributeLang $optionLang */ ?>
		<?php $optionLang = $shopOption->getLang() ?>
		<div class="form-group">
			<label class="control-label"><?= $optionLang->name ?></label>
			<?php foreach ($shopProductOptions as $n => $shopProductOption) { ?>
				<?php foreach ($shopProductOption->initLangs() as $lang) { ?>
					<?= $shopProductOption->shopAttribute->formField($form, '[' . $shopOption->id . '][' . $n . '][' . $lang->lang_id . ']value', Lang::getLangIcon($lang->lang_id), $lang) ?>
				<?php } ?>
			<?php } ?>
		</div>
	<?php } ?>

	<?= ProductOptionsInit::widget() ?>
	<?php /* @var \common\behaviors\ShopOptionBehavior $options */ ?>
	<?php $options = $model->getBehavior('shopOptions') ?>
	<?php foreach ($options->initOptions() as $option) { ?>
		<?php /* @var \common\models\ShopOption|\common\behaviors\LangBehavior $shopOption */ ?>
		<?php $shopOption = $option['option'] ?>
		<?php /* @var \common\models\ShopProductOptions[]|\common\behaviors\LangBehavior[] $shopProductOptions */ ?>
		<?php $shopProductOptions = $option['items'] ?>
		<?php /* @var \common\models\ShopOptionLang $optionLang */ ?>
		<?php $optionLang = $shopOption->getLang() ?>
		<div class="form-group" data-group-option-id="<?= $shopOption->id ?>">
			<label class="control-label"><?= $optionLang->name ?></label>
			<div class="option-groups">
				<?php foreach ($shopProductOptions as $n => $shopProductOption) { ?>
					<?= ProductOptionHtml::widget([
						'optionId' => $shopOption->id,
						'productOptionsModel' => $shopProductOption,
						'order' => $n,
					]) ?>
				<?php } ?>
			</div>
			<div class="option-group-add btn btn-info">Добавить опцию</div>
		</div>
	<?php } ?>

	<?php foreach ($model->initLinkedProducts() as $link_id => $link) { ?>
		<?= $form->field($model, 'linkedProducts[' . $link_id . ']')->widget(Select2::class, [
			'data' => ArrayHelper::map(\common\models\ShopProduct::find()->where(['not', ['id' => $model->id]])->with(['langsRefCurrent'])->all(), 'id', 'lang.name'),
			'language' => Yii::$app->language,
			'options' => [
				'placeholder' => Yii::t('site', 'Введите название товара...'),
				'multiple' => true,
			],
			'pluginOptions' => [
				'allowClear' => true,
				'tags' => true,
			],
		])->label($link['name']); ?>
	<?php } ?>

	<?php foreach ($model->initLangs() as $lang) { ?>
		<?= $form->field($lang, '[' . $lang->lang_id . ']seo_title')->label('SEO-title ' . Lang::getLangIcon($lang->lang_id)); ?>
	<?php } ?>

	<?php foreach ($model->initLangs() as $lang) { ?>
		<?= $form->field($lang, '[' . $lang->lang_id . ']seo_description')->textarea(['rows' => 6])->label('SEO-description ' . Lang::getLangIcon($lang->lang_id)); ?>
	<?php } ?>

	<div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
