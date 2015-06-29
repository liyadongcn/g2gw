<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PricehistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pricehistories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pricehistory-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pricehistory', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'goods_id',
            'market_price',
            'real_price',
            'quotation_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
