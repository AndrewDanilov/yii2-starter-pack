<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\ShopBrand;
use common\helpers\NestedCategoryHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ShopProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Товары';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новый товар', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
	        [
		        'attribute' => 'id',
		        'headerOptions' => ['width' => 100],
	        ],
	        'article',
	        [
		        'attribute' => 'image',
		        'format' => 'raw',
		        'headerOptions' => ['style' => 'width:100px'],
		        'value' => function($model) { return Html::img($model->image, ['width' => '100']); },
	        ],
	        [
		        'attribute' => 'name',
		        'value' => 'lang.name',
	        ],
            'old_price',
            'price',
	        [
		        'attribute' => 'brand_id',
		        'value' => 'brand.lang.name',
		        'filter' => ShopBrand::getBrandsList(),
	        ],
	        [
		        'attribute' => 'category_id',
		        'value' => 'categoriesDelimitedString',
		        'filter' => NestedCategoryHelper::getDropdownTree(),
		        'filterOptions' => ['style' => 'font-family:monospace;'],
	        ],
	        'is_popular:boolean',

	        [
		        'class' => 'andrewdanilov\gridtools\FontawesomeActionColumn',
		        'template' => '{update}{delete}',
	        ],
        ],
    ]); ?>
</div>
