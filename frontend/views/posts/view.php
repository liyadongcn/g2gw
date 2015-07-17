<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model common\models\Posts */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-view">

    <h1><?php //echo Html::encode($this->title) ?></h1>

    <div class="page-header">
  		<h3><?= html::encode($model->post_title)?><small></small></h3>
	</div>
	
	<div class="action">
            <span class="user"><a href="/user/27646"><span class="glyphicon glyphicon-user"></span><?= html::encode($model->user->username)?></a></span>
            <span class="time"><span class="glyphicon glyphicon-time"></span> <?= html::encode($model->created_date)?></span>
            <span class="views"><span class="glyphicon glyphicon-eye-open"></span><?= Html::encode($model->view_count) ?>次浏览</span>
            <span class="comments"><a href="#comments"><span class="glyphicon glyphicon-comment"></span> <?= Html::encode($model->comment_count) ?>条评论</a></span>
            <span class="favourites"><a href="<?= Url::to(['star','id' => $model->id])?>" data-toggle="tooltip" data-placement="top" title="收藏" ><span class="glyphicon glyphicon-star"></span> <em><?= Html::encode($model->star_count) ?></em></a></span>
            <span class="vote"><a class="up" href="<?= Url::to(['thumbsup','id' => $model->id])?>" title="" data-toggle="tooltip" data-original-title="顶"><span class="glyphicon glyphicon-thumbs-up"></span> <em><?= Html::encode($model->thumbsup) ?></em></a><a class="down" href="<?= Url::to(['thumbsdown','id' => $model->id])?>" title="" data-toggle="tooltip" data-original-title="踩"><span class="glyphicon glyphicon-thumbs-down"></span> <em><?= Html::encode($model->thumbsdown) ?></em></a></span>
    </div>
	<!-- 文章图片列表开始 -->
	<?php $album=$model->album;?>
	<?php if(!empty($album)):?>
			<div class="center-block">		
			<?php foreach ($album as $image): ?>
				<a href=<?= Url::to($model->url)?>>
				<?= html::img($image->filename,['class'=>'img-responsive'])?>	
				</a>			
			</div>
		<?php endforeach;?>
	<?php endif;?>
<!-- 文章图片列表结束 -->
	<p>
		<?= html::encode($model->post_content)?>
	</p>
	
</div>

<!-- 文章标签开始 -->
	<div class="panel panel-default">
  		<div class="panel-body">
  			<span class="glyphicon glyphicon-tag"></span>
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
<!-- 文章标签结束 -->
	
<!-- 相关同品牌活动及文章开始 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">相关同品牌活动及文章</h3>
	</div>
	<div class="panel-body">
	<ul class="list-group">
	<?php $relatedPosts=$model->getRelatedPosts()->models;?>
	<?php if($relatedPosts):?>
		<?php foreach ($relatedPosts as $post):?>
			<a href="<?= Url::to(['posts/view','id'=>$post->id])?>"
				class="list-group-item"><?= html::encode($post->post_title)?>
				<span class='glyphicon glyphicon-time pull-right'><?= html::encode($post->updated_date)?></span>
			</a>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
	</div>
</div>
<!-- 相关同品牌活动及文章结束 -->

<!-- 最新文章开始 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">最新活动及文章</h3>
	</div>
	<div class="panel-body">
	<ul class="list-group">
	<?php $latestPosts=$model->getLatestPosts(5)->all();?>
	<?php if($latestPosts):?>
		<?php foreach ($latestPosts as $post):?>
			<a href="<?= Url::to(['posts/view','id'=>$post->id])?>" class="list-group-item"><?= html::encode($post->post_title)?>
			<span class='glyphicon glyphicon-time pull-right'><?= html::encode($post->updated_date)?></span>
			</a>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
	</div>
</div>
<!-- 最新文章结束 -->
    
<div id="comments">
	<div class="page-header">
		<h2>
			共 <em><?= Html::encode($model->comment_count)?></em>
			条评论
		</h2>
		<ul id="w0" class="nav nav-tabs nav-sub">
			<li class="active">
				<a href="/tutorial/332#comments">默认排序</a>
			</li>
			<li>
				<a href="/tutorial/332?sort=desc#comments">最后评论</a>
			</li>
		</ul>
	</div>

	<ul id="w1" class="media-list">
	<?php
		$dataProvider=$model->getComments(); 
		$comments=$dataProvider->models;		
		echo $this->renderAjax('@app/views/comment/_comment.php',['comments'=>$comments]);
		echo LinkPager::widget([
 		'pagination' => $dataProvider->getPagination(),
 		]);		
	?>
	</ul>
</div>


<div class="comment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // echo $form->field($model, 'parent_id')->textInput() ?>

    <?php // echo $form->field($model, 'model_type')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'model_id')->textInput() ?>

    <?php // echo $form->field($model, 'approved')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'thumbsup')->textInput() ?>

    <?php // echo $form->field($model, 'thumbsdown')->textInput() ?>

    <?php echo $form->field($model->comment, 'content')->textarea(['rows' => 6]) ?>

    <?php // echo $form->field($model, 'created_date')->textInput() ?>

    <?php // echo $form->field($model, 'updated_date')->textInput() ?>

    <?php // echo $form->field($model, 'userid')->textInput() ?>

    <?php // echo $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'author_ip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('发表评论', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <?php //隐藏的回复框?>
    
     <?php $form = ActiveForm::begin(['options'=>['class' => 'reply-form hidden']]); ?>

    <?php  echo $form->field($model->comment, 'parent_id')->hiddenInput(['class'=>'parent_id'])->label(false) ?>

    <?php echo $form->field($model->comment, 'content')->textarea(['rows' =>3])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('回复评论', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

