<?php

use common\models\User;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\UserSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новый пользователь', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
	        [
		        'attribute' => 'id',
		        'headerOptions' => ['width' => 100],
	        ],
	        'email:email',
            'name',
	        [
		        'attribute' => 'status',
		        'filter' => $searchModel::getStatusDropdownList(),
		        'value' => 'statusText',
	        ],
	        [
		        'attribute' => 'created_at',
		        'format' => 'datetime',
		        'filter' => '',
	        ],
	        [
		        'attribute' => 'updated_at',
		        'format' => 'datetime',
		        'filter' => '',
	        ],
	        [
		        'attribute' => 'online_at',
		        'format' => 'datetime',
		        'filter' => '',
	        ],
	        'is_admin:boolean',

	        [
		        'class' => 'andrewdanilov\gridtools\FontawesomeActionColumn',
		        'template' => '{update}{delete}',
	        ],
        ],
    ]); ?>
</div>
