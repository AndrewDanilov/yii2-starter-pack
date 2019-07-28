<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\helpers\NestedCategoryHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ShopCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="shop-category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новая категория', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
	        [
		        'attribute' => 'id',
		        'headerOptions' => ['width' => 100],
	        ],
	        [
		        'attribute' => 'image',
		        'format' => 'raw',
		        'headerOptions' => ['style' => 'width:100px'],
		        'value' => function($model) { return Html::img($model->image, ['width' => '100']); },
	        ],
	        [
		        'attribute' => 'parent_id',
		        'value' => 'parent.lang.name',
		        'filter' => NestedCategoryHelper::getDropdownTree(),
		        'filterOptions' => ['style' => 'font-family:monospace;'],
	        ],
            [
            	'attribute' => 'name',
            	'value' => 'lang.name',
            ],
            'order',

	        [
		        'class' => 'andrewdanilov\gridtools\FontawesomeActionColumn',
		        'template' => '{update}{delete}',
	        ],
        ],
    ]); ?>
</div>
