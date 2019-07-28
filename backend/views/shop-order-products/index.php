<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\components\TotalDataColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ShopOrderProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары заказа № ' . $searchModel->order_id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['shop-order/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-order-products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
	    'showFooter' => true,
        'columns' => [
	        [
		        'attribute' => 'product_id',
		        'headerOptions' => ['width' => 100],
	        ],
	        [
		        'attribute' => 'image',
		        'format' => 'raw',
		        'headerOptions' => ['style' => 'width:100px'],
		        'value' => function($model) { return Html::img($model->product->image, ['width' => '100']); },
	        ],
            [
            	'attribute' => 'name',
            	'format' => 'raw',
	            'value' => function($model) {
		            /* @var \common\models\ShopOrderProducts $model */
		            return Html::a($model->name, Url::to(['shop-product/update', 'id' => $model->product_id]));
	            },
			],
	        [
		        'attribute' => 'option',
		        'value' => 'productOptionsStr',
	        ],
            'count',
            [
            	'attribute' => 'price',
	            'footer' => 'Итого:',
            ],
            [
            	'attribute' => 'summ',
	            'value' => function($model) {
		            return $model->count * $model->price;
	            },
	            'class' => TotalDataColumn::class,
            ],

	        [
		        'class' => 'andrewdanilov\gridtools\FontawesomeActionColumn',
		        'template' => '{delete}',
	        ],
        ],
    ]); ?>

</div>
