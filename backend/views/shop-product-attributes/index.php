<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ShopProductAttributesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shop Product Attributes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-product-attributes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Shop Product Attributes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'attribute_id',
            'product_id',

            ['class' => 'andrewdanilov\gridtools\FontawesomeActionColumn'],
        ],
    ]); ?>
</div>
