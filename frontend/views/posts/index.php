<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\Posts;
use common\models\Category;
use common\models\User;
use common\models\Relationships;
use common\models\RelationshipsMap;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '发帖';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
<!-- 页面左半部分开始 -->
	<div class="col-lg-9 ">
	<div class="posts-index">

<?php $sort=$dataProvider->sort;?>
<?php echo $sort->link('view_count') . ' | ' . $sort->link('thumbsup'). ' | ' . $sort->link('star_count'). ' | ' . $sort->link('comment_count'). ' | ' . $sort->link('updated_date');?>    


<?php $models=$dataProvider->models;?>
<?php if($models) :?>
<ul class="list-group">
	<li class="list-group-item">
  	<?php foreach ($models as $model):?>
  		<div class="panel panel-default">
			<div class="panel-body">
				<div class="media">
					<div class="media-left media-middle">
						<a href="<?= Url::to(['posts/view','id'=>$model->id])?>">
						<?php $images=$model->album;?>
						<?php if($images):?>
							<?php foreach ($images as $image) :?>
								<img class=" media-object img-rounded" src="<?= html::encode($image->filename)?>"	alt="..." width="64">
							<?php endforeach;?>
						<?php else :?>
								<img class=" media-object img-rounded" src=""	alt="..." width="64">
						<?php endif;?>
						</a>
					</div>
					<div class="media-body">
						<h1 class="media-heading"><?= html::encode($model->post_title)?></h1>
						<p>
							<?= html::encode($model->post_content)?>
						</p>
						<p class="text-right">
							<?php if ($model->url) :?>
								<a class="btn btn-success" href="<?= html::encode($model->url);?>" role="button">去购买</a>
							<?php endif;?>
						</p>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class='text-left'>
	  					<?php $tagMaps=$model->getTagMaps()->all();?>
	  					<?php if($tagMaps):?>
	  					<?php foreach ($tagMaps as $tagMap):?>  			
	  						<a href="<?= Url::to(['posts/search-by-tag','tagid' =>  $tagMap->tag->id])?>"><span class="label label-success"><?= $tagMap->tag->name?></span></a>
	  					<?php endforeach;?>	
	  					<?php endif;?>		
	<!-- 			<span class="label label-primary">Primary</span> -->
						<!-- 			<span class="label label-success">Success</span> -->
						<!-- 			<span class="label label-info">Info</span> -->
						<!-- 			<span class="label label-warning">Warning</span> -->
						<!-- 			<span class="label label-danger">Danger</span> -->
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<p class='text-right'>
						<a href="<?= Url::to(['posts/thumbsup','id' => $model->id])?>"> <span
							class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
						</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsup) ?></span>
						&nbsp;| <a href="<?= Url::to(['posts/thumbsdown','id' => $model->id])?>">
							<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
						</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsdown) ?></span>
						&nbsp;| <span class="glyphicon glyphicon-comment"
							aria-hidden="true"></span> <span class="badge" aria-hidden="true"><?= Html::encode($model->comment_count) ?></span>
						&nbsp;| <span class="glyphicon glyphicon-eye-open"></span> <span
							class="badge"><?= Html::encode($model->view_count) ?></span>
						&nbsp;| <a href="<?= Url::to(['posts/star','id' => $model->id])?>">
							<span class="glyphicon glyphicon-star"></span>
							</a> <span class="badge"><?= Html::encode($model->star_count) ?></span>
					</p>
				</div>
				</div>
			</div>
		</div>
  <?php endforeach;?>
  </li>
</ul>
<?php else:?>
	<div class="alert alert-danger" role="alert">抱歉！啥也没找到！</div>
<?php endif;?>

<?php 
// 显示分页
echo LinkPager::widget([
		'pagination' => $dataProvider->getPagination(),
]);
?>

</div>
	
	</div>
<!-- 页面左半部分结束 -->
	
<!-- 页面右半部分开始 -->
	<div class="col-lg-3 ">

<!-- 用户收藏的帖子开始 -->
	<?php if(!yii::$app->user->isGuest):?>
	<?php $user=User::findIdentity(yii::$app->user->id);?>
	<?php if($user):?>
	<?php $starPostsProvider=$user->getRelationshipModels(Relationships::RELATIONSHIP_STAR, RelationshipsMap::MODEL_TYPE_POST);?>
	<?php if($starPostsProvider->totalCount!=0):?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">收藏的帖子<span class="badge pull-right"><?= html::encode($starPostsProvider->totalCount)?></span></h3>
    </div>
    <div class="panel-body">
    <ul class="list-group">
    	<?php $posts=$starPostsProvider->models;?>
        <?php if($posts):?>
            <?php foreach ($posts as $post):?>
            <li class="list-group-item">
                <a href="<?= Url::to(['posts/view','id'=>$post->id])?>"><?= html::encode($post->post_title)?></a>
                <span class="pull-right"><a href="<?= Url::to(['posts/remove-star','id'=>$post->id])?>">取消收藏</a></span>
            </li>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
    </div>
    <div class="panel-footer">
        <span>
    	<?php echo LinkPager::widget([
            'pagination' => $starPostsProvider->getPagination(),
            ]);
        ?>
    	</span>
    </div>
</div>
	<?php endif;?>
	<?php endif;?>
	<?php endif;?>
<!-- 用户收藏的帖子结束 -->
	
	<!-- 热门文章开始 -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">热门文章</h3>
	</div>
	<div class="panel-body">
	<ul class="list-group">
	<?php $hotestPosts=Posts::getHotestPosts(5)->all();?>
	<?php if($hotestPosts):?>
		<?php foreach ($hotestPosts as $post):?>
			<a href="<?= Url::to(['posts/view','id'=>$post->id])?>" class="list-group-item"><?= html::encode($post->post_title)?></a>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
	</div>
</div>
<!-- 热门文章结束 -->

<!-- 最新文章开始 -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">最新文章</h3>
	</div>
	<div class="panel-body">
	<ul class="list-group">
	<?php $latestPosts=Posts::getLatestPosts(5)->all();?>
	<?php if($latestPosts):?>
		<?php foreach ($latestPosts as $post):?>
			<a href="<?= Url::to(['posts/view','id'=>$post->id])?>" class="list-group-item"><?= html::encode($post->post_title)?></a>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
	</div>
</div>
<!-- 最新文章结束 -->

	</div>
<!-- 页面右半部分结束 -->
</div>




