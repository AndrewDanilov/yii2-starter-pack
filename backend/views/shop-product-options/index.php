<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ShopProductOptionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shop Product Options';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-product-options-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Shop Product Options', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'option_id',
            'product_id',
            'margin',
            'margin_type',

            ['class' => 'andrewdanilov\gridtools\FontawesomeActionColumn'],
        ],
    ]); ?>
</div>
