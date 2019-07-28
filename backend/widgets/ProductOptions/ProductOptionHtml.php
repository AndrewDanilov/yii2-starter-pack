<?php

/**
 * Возвращает html код связи опции с товаром, содержащий
 * поля для ввода значений как самой связи опция-товар, так
 * и поля для вариантов перевода этой связи.
 */

namespace backend\widgets\ProductOptions;

use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\behaviors\LangBehavior;
use common\models\Lang;
use common\models\ShopProductOptions;

class ProductOptionHtml extends Widget
{
	public $optionId;
	/* @var ShopProductOptions|LangBehavior $productOptionsModel */
	public $productOptionsModel = null;
	public $order = null; // номер п/п, используемый для группировки значений и переводов опции в один массив

	public function run()
	{
		if ($this->productOptionsModel === null) {
			$this->productOptionsModel = new ShopProductOptions;
		}

		if ($this->order === null) {
			$this->order = substr(ceil(microtime(true) * 100), -6);
		}

		$option_fields = [];
		$lang_fields = [];

		ob_start(); // буферизуем вывод, чтобы не печатался html код формы
		$form = ActiveForm::begin();
		foreach ($this->productOptionsModel->initLangs() as $lang) {
			$lang_fields[] = $form->field($lang, '[' . $this->optionId . '][' . $this->order . '][' . $lang->lang_id . ']value')->textInput()->label(Lang::getLangIcon($lang->lang_id));
		}
		$option_fields[] = $form->field($this->productOptionsModel, '[' . $this->optionId . '][' . $this->order . ']margin')->textInput();
		$option_fields[] = $form->field($this->productOptionsModel, '[' . $this->optionId . '][' . $this->order . ']margin_type')->dropDownList(['1' => Lang::getBaseCurrency(), '2' => '%']);
		ActiveForm::end();
		ob_end_clean();

		$optionGroupContent = '';
		foreach ($lang_fields as $lang_field) {
			$optionGroupContent .= Html::tag('div', $lang_field, ['class' => 'option-group-lang']);
		}
		foreach ($option_fields as $option_field) {
			$optionGroupContent .= $option_field;
		}
		$optionGroupContent .= Html::tag('div', 'Удалить опцию', ['class' => 'option-group-remove btn btn-danger']);

		return Html::tag('div', $optionGroupContent, ['class' => 'option-group']);
	}
}