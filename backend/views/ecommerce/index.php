<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\EcommerceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ecommerces';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ecommerce-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ecommerce', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Export Ecommerce', ['export-urls'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'brand.en_name',
            'website',
            'name',
            'is_domestic',
            'accept_order',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
