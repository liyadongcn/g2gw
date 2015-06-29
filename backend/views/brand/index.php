<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

	<h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Brand', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php 
    	echo  GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => false,//$searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'en_name',
            'country.cn_name',
            //'logo',
            'cn_name',
            //'introduction:ntext',
            //'baidubaike',
           // 'thumbsup',
            //'thumbsdown',
            'company.name',
            'comment_count',
            'view_count',

            ['class' => 'yii\grid\ActionColumn'],
        ] ] );
    	?>

</div>

<?php $models=$dataProvider->models;?>
<?php if($models) :?>
<ul class="list-group">
	<li class="list-group-item">
  	<?php foreach ($models as $model):?>
  		<div class="panel panel-default">
			<div class="panel-body">
				<div class="media">
					<div class="media-left media-middle">
						<a href="<?= Url::to(['view','id'=>$model->id])?>"> <img
							class=" media-object img-rounded" src="<?= html::encode($model->logo)?>"
							alt="..." width="200">
						</a>
					</div>
					<div class="media-body">
						<h1 class="media-heading"><?= html::encode($model->en_name)?></h1>
						<p>
							<?= html::encode($model->introduction)?>
						</p>
						<p class="text-right">
							<?php $ecommerces=$model->ecommerces;?>
							<?php if ($ecommerces) :?>
							<?php foreach ($ecommerces as $ecommerce) :?>
								<a class="btn btn-success" href="<?= html::encode($ecommerce->website);?>" role="button">去<?= html::encode($ecommerce->name);?>购物</a>
							<?php endforeach;?>
							<?php endif;?>
						</p>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div>
				<div class='text-left'>
  					<?php $tagMaps=$model->getTagMaps()->all();?>
  					<?php if($tagMaps):?>
  					<?php foreach ($tagMaps as $tagMap):?>  			
  						<span class="label label-success"><?= $tagMap->tag->name?></span>
  					<?php endforeach;?>	
  					<?php endif;?>		
<!-- 			<span class="label label-primary">Primary</span> -->
					<!-- 			<span class="label label-success">Success</span> -->
					<!-- 			<span class="label label-info">Info</span> -->
					<!-- 			<span class="label label-warning">Warning</span> -->
					<!-- 			<span class="label label-danger">Danger</span> -->
				</div>
				<p class='text-right'>
					<a href="<?= Url::to(['thumbsup','id' => $model->id])?>"> <span
						class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
					</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsup) ?></span>
					&nbsp;| <a href="<?= Url::to(['thumbsdown','id' => $model->id])?>">
						<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
					</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsdown) ?></span>
					&nbsp;| <span class="glyphicon glyphicon-comment"
						aria-hidden="true"></span> <span class="badge" aria-hidden="true"><?= Html::encode($model->comment_count) ?></span>
					&nbsp;| <span class="glyphicon glyphicon-eye-open"></span> <span
						class="badge"><?= Html::encode($model->view_count) ?></span>
				</p>
				</div>
			</div>
		</div>
  <?php endforeach;?>
  </li>
</ul>
<?php endif;?>

<?php 
// 显示分页
echo LinkPager::widget([
		'pagination' => $dataProvider->getPagination(),
]);
?>
