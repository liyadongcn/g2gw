<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goods';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Goods', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'brand.en_name',
            'code',
            //'description:ntext',
            //'thumbsup',
            // 'thumbsdown',
            // 'url:url',
            'title',
            // 'comment_status',
            // 'comment_count',
            // 'created_date',
            // 'updated_date',
            // 'interested_count',
            // 'recomended_count',
             'view_count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
