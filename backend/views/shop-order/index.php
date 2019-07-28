<?php

use yii\helpers\Html;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use yii\helpers\Url;
use common\models\ShopPay;
use common\models\ShopDelivery;
use common\models\ShopOrder;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ShopOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
	        [
		        'attribute' => 'id',
		        'headerOptions' => ['width' => 100],
	        ],
	        [
		        'attribute' => 'created_at',
		        'format' => 'raw',
		        'filter' => DatePicker::widget([
			        'model' => $searchModel,
			        'attribute' => 'created_at',
			        'language' => 'ru',
			        'template' => '{input}{addon}',
			        'clientOptions' => [
				        'autoclose' => true,
				        'format' => 'dd.mm.yyyy',
				        'clearBtn' => true,
				        'todayBtn' => 'linked',
			        ],
			        'clientEvents' => [
				        'clearDate' => 'function (e) {$(e.target).find("input").change();}',
			        ],
		        ]),
	        ],
            [
            	'attribute' => 'account_info',
            	'format' => 'raw',
            	'value' => function(ShopOrder $model) {
		            return $model->account->getAccountStr(true);
	            },
            ],
            [
            	'attribute' => 'addressee',
	            'format' => 'raw',
	            'value' => 'addresseeStr',
            ],
            [
            	'attribute' => 'address',
	            'value' => 'addressStr',
                'filter' => '',
            ],
            [
            	'attribute' => 'pay_id',
	            'value' => 'pay.lang.name',
	            'filter' => ShopPay::getPayList(),
	        ],
	        [
		        'attribute' => 'delivery_id',
		        'value' => 'delivery.lang.name',
		        'filter' => ShopDelivery::getDeliveryList(),
	        ],
	        'summ',
            [
            	'attribute' => 'status',
	            'value' => 'statusStr',
	            'filter' => ShopOrder::getStatusList(),
            ],

	        [
		        'class' => 'andrewdanilov\gridtools\FontawesomeActionColumn',
		        'template' => '{update}{cart}{delete}',
		        'buttons' => [
		        	'cart' => function ($url, $model) {
				        return Html::a(Html::tag('span', '', ['class' => 'fa fa-shopping-cart']), Url::to(['shop-order-products/index', 'id' => $model->id]), ['title' => 'Товары заказа']);
			        },
		        ]
	        ],
        ],
    ]); ?>
</div>
