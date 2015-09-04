<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Posts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'post_title',
            'post_content:ntext',
            'brand.en_name',
            'post_status',
            // 'url:url',
            'created_date',
            'updated_date',
            'user.username',
            // 'comment_count',
            // 'thumbsup',
            // 'thumbsdown',
            // 'effective_date',
            // 'expired_date',
            // 'view_count',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
