<?php

namespace frontend\widgets;

use yii\base\Widget;
use common\models\ShopProduct;
use common\models\ShopProductRelations;

class LinkedProducts extends Widget
{
	public $id = null;
	public $link = null;

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		$productIds = ShopProductRelations::find()->joinWith('shopRelation as relation')->andWhere(['product_id' => $this->id, 'relation.key' => $this->link])->andWhere(['not', ['linked_product_id' => $this->id]])->select('linked_product_id')->column();
		$products = ShopProduct::findAll(['id' => $productIds]);
		if ($products) {
			return $this->render('shop/linked-products', ['products' => $products]);
		}
		return false;
	}
}