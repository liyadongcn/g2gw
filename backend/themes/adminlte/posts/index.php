<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-index box box-default">

<div class="box-body">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Posts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
    	'options' => ['class' => 'grid-view table-responsive'],
    	'tableOptions' => ['class' => ' table table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'post_title',
            //'post_content:ntext',
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
    
<?php $models=$dataProvider->models;?>
<?php if($models) :?>

  	<?php foreach ($models as $model):?>
  	<div class="post">
      <a href="<?= Url::to(['posts/view','id'=>$model->id])?>">
						<?php $image=$model->albumDefaultImg;?>
						<?php if($image):?>
								<img class=" img-responsive pull-center" src="<?= html::encode($image->filename)?>"	alt="<?= html::encode($model->post_title)?>">
						<?php else :?>
<!-- 								<img class=" media-object img-rounded" src=""	alt="..." > -->
						<?php endif;?>
						</a>

        	<h3 ><a href="<?= Url::to(['posts/view','id'=>$model->id])?>"><?= html::encode($model->post_title)?></a></h3>
        
		        	<div class="btn-group btn-sm" role="group" aria-label="...">
						<?php if ($model->url) :?>
							<a class="btn btn-info btn-flat" href="<?= html::encode($model->url);?>" target="_blank" role="button"><span class="">去购买</span></a>
						<?php endif;?>
						<?php $links = $model->links?>
						<?php if($links):?>
							<?php foreach ($links as $link):?>
							<a class="btn btn-info btn-flat" target="_blank" href=<?= Url::to($link->link)?>><span class=""><?= $link->link_name ?></span></a>
							<?php endforeach;?>
						<?php endif;?>
					</div>
			

				<ul class="list-inline">
				<li>
	  					<?php $tagMaps=$model->getTagMaps()->all();?>
	  					<?php if($tagMaps):?>
	  					<span class="glyphicon glyphicon-tags">&nbsp;</span>
	  					<?php foreach ($tagMaps as $tagMap):?>  			
	  						<a href="<?= Url::to(['posts/search-by-tag','tagid' =>  $tagMap->tag->id])?>"><span class="label label-default"><?= $tagMap->tag->name?></span></a>
	  					<?php endforeach;?>	
	  					<?php endif;?>		
				</li>
				<li class="pull-right" >
						<a href="<?= Url::to(['posts/thumbsup','id' => $model->id])?>"> <span
							class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
						</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsup) ?></span>
						<a href="<?= Url::to(['posts/thumbsdown','id' => $model->id])?>">
							<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
						</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsdown) ?></span>
						<span class="glyphicon glyphicon-comment"
							aria-hidden="true"></span> <span class="badge" aria-hidden="true"><?= Html::encode($model->comment_count) ?></span>
						<span class="glyphicon glyphicon-eye-open"></span> <span
							class="badge"><?= Html::encode($model->view_count) ?></span>
						<a href="<?= Url::to(['posts/star','id' => $model->id])?>">
							<?php if($model->isStared()):?>
										<span class="glyphicon glyphicon-star"></span>
									<?php else :?>
										<span class="glyphicon glyphicon-star-empty"></span>
									<?php endif;?>
							</a> <span class="badge"><?= Html::encode($model->star_count) ?></span>
						<span class="glyphicon glyphicon-time"></span><span class="badge" aria-hidden="true"><?= html::encode(yii::$app->formatter->asRelativeTime($model->updated_date,time()+8*3600))?></span>
				</li>
				</ul>
      
    </div>
  <?php endforeach;?>

<?php else:?>
	<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span>抱歉！啥也没找到！</div>
<?php endif;?>

<?php 
// 显示分页
echo LinkPager::widget([
		'pagination' => $dataProvider->getPagination(),
]);
?>

</div>
</div>
