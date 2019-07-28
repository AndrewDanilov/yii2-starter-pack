<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Setting;
use common\models\SettingCategory;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SettingSearch|\common\behaviors\LangBehavior|\common\behaviors\ValueTypeBehavior */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Настройки сайта';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новый параметр', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Разделы настроек', ['setting-category/index'], ['class' => 'btn btn-warning']) ?>
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
		        'attribute' => 'category_id',
		        'value' => 'category.name',
		        'filter' => SettingCategory::find()->select(['name', 'id'])->indexBy('id')->column(),
	        ],
            'key',
            'name',
	        [
		        'attribute' => 'value',
		        'format' => 'raw',
		        'value' => function(Setting $model) {
			        /* @var $model Setting|\common\behaviors\LangBehavior|\common\behaviors\ValueTypeBehavior */
			        return $model->prettifyValue($model->getLang()->value, 20);
		        },
	        ],
            [
            	'attribute' => 'type',
	            'value' => 'typeName',
	            'filter' => $searchModel->getTypeList(),
            ],

	        [
		        'class' => 'andrewdanilov\gridtools\FontawesomeActionColumn',
		        'template' => '{update}{delete}',
	        ],
        ],
    ]); ?>
</div>
