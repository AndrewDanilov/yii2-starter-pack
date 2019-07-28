<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ShopCategoryOptionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shop Category Options';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-category-options-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Shop Category Options', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'option_id',
            'category_id',

            ['class' => 'andrewdanilov\gridtools\FontawesomeActionColumn'],
        ],
    ]); ?>
</div>
