<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Lang;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Языки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lang-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новый язык', ['create'], ['class' => 'btn btn-success']) ?>
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
		        'headerOptions' => ['style' => 'width:40px'],
		        'value' => function($model) { return Html::img($model->image, ['width' => '40']); },
	        ],
            'key',
            'is_default:boolean',
            'name',
            'currency',
            'currency_value',

	        [
		        'class' => 'andrewdanilov\gridtools\FontawesomeActionColumn',
		        'template' => '{update}{delete}',
		        'buttons' => [
                    'delete' => function ($url, $model) {
	                    /* @var $model Lang */
	                    if (!$model->is_default) {
		                    return Html::a(Html::tag('span', '', ['class' => 'fa fa-trash']), $url, ['data' => ['confirm' => 'Вы уверены, что хотите удалить этот элемент?', 'method' => 'post']]);
	                    }
	                    return '';
                    },
                ],
	        ],
        ],
    ]); ?>
</div>
