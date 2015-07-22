<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\widgets\LinkPager;
use yii\i18n\Formatter;
use common\models\helper\TimeHelper;


/* @var $this yii\web\View */
/* @var $model common\models\Posts */

$this->title = Yii::$app->name.'-'.$model->post_title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-view">

    <h1><?php //echo Html::encode($this->title) ?></h1>

    <div class="page-header">
  		<h3><?= html::encode($model->post_title)?><small></small></h3>
	</div>
	
	<div class="action">
            <span class="user"><a href="<?= Url::to(['user/view','id'=>$model->userid])?>"><span class="glyphicon glyphicon-user"></span><?= html::encode($model->user->username)?></a></span>
            <span class="time"><span class="glyphicon glyphicon-time"></span> <?= html::encode(TimeHelper::getRelativeTime($model->updated_date))?></span>
            <span class="views"><span class="glyphicon glyphicon-eye-open"></span><?= Html::encode($model->view_count) ?>次浏览</span>
            <span class="comments"><a href="#comments"><span class="glyphicon glyphicon-comment"></span> <?= Html::encode($model->comment_count) ?>条评论</a></span>
            <span class="favourites"><a href="<?= Url::to(['star','id' => $model->id])?>" data-toggle="tooltip" data-placement="top" title="收藏" ><span class="glyphicon glyphicon-star"></span> <em><?= Html::encode($model->star_count) ?>人收藏</em></a></span>
            <span class="vote"><a class="up" href="<?= Url::to(['thumbsup','id' => $model->id])?>" title="" data-toggle="tooltip" data-original-title="顶"><span class="glyphicon glyphicon-thumbs-up"></span> <em><?= Html::encode($model->thumbsup) ?></em></a><a class="down" href="<?= Url::to(['thumbsdown','id' => $model->id])?>" title="" data-toggle="tooltip" data-original-title="踩"><span class="glyphicon glyphicon-thumbs-down"></span> <em><?= Html::encode($model->thumbsdown) ?></em></a></span>
    </div>
	<!-- 文章图片列表开始 -->
	<?php $album=$model->album;?>
	<?php if(!empty($album)):?>
			
			<?php foreach ($album as $image): ?>
				<a href=<?= Url::to($model->url)?>>
				<?= html::img($image->filename,['class'=>'img-responsive center-block'])?>	
				</a>			
			
		<?php endforeach;?>
	<?php endif;?>
<!-- 文章图片列表结束 -->
	<p class="lead">
		<?= html::encode($model->post_content)?>
	</p>
	
</div>

<!-- 点赞吐槽开始 -->
<p class="text-center">
	
			<a class="up"
			href="<?= Url::to(['thumbsup','id' => $model->id])?>" title=""
			data-toggle="tooltip" data-original-title="顶">
			<span style="font-size:36px;color:#F00" class="glyphicon glyphicon-thumbs-up"></span><em><?= Html::encode($model->thumbsup) ?></em>
			</a>
			&nbsp;&nbsp;&nbsp;
			<a
			class="down" href="<?= Url::to(['thumbsdown','id' => $model->id])?>"
			title="" data-toggle="tooltip" data-original-title="踩">
			<span style="font-size:36px;color:#999" class="glyphicon glyphicon-thumbs-down"></span> <em><?= Html::encode($model->thumbsdown) ?></em>
			</a>
	
</p>
<!-- 点赞吐槽结束 -->

<!-- 收藏开始 -->
<p class="text-center">
<a class="btn btn-success btn-lg" href=<?= Url::to($model->url)?>><span class="glyphicon glyphicon-shopping-cart">去购买</span></a>
<?php if($model->isStared()):?>
				<a class="btn btn-primary btn-lg" href="<?= Url::to(['remove-star','id' => $model->id])?>"
					data-toggle="tooltip" data-placement="top" title="收藏"><span
					class="glyphicon glyphicon-star">取消收藏</span> </a>
			<?php else :?>
				<a class="btn btn-primary btn-lg" href="<?= Url::to(['star','id' => $model->id])?>"
					data-toggle="tooltip" data-placement="top" title="收藏"><span
					class="glyphicon glyphicon-star-empty">收藏</span> </a>
			<?php endif;?>
</p>
<!-- 收藏结束 -->
			
<!-- 文章标签开始 -->
	<div class="panel panel-default">
  		<div class="panel-body">
  			<span class="glyphicon glyphicon-tag"></span>
  			<?php $tagMaps=$model->getTagMaps()->all();?>
  			<?php if($tagMaps):?>
  				<?php foreach ($tagMaps as $tagMap):?>  			
  					<a href="<?= Url::to(['posts/search-by-tag','tagid' =>  $tagMap->tag->id])?>"><span class="label label-default"><?= $tagMap->tag->name?></span></a>
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
			<a href="<?= Url::to(['posts/view','id'=>$post->id])?>"	class="list-group-item">
			<div class="row">
            		<div class="col-md-9"><?= html::encode($post->post_title)?></div>
            		<div class="col-md-3"><span class='glyphicon glyphicon-time pull-right'><?= html::encode($post->updated_date)?></span></div>
             </div>
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
			<a href="<?= Url::to(['posts/view','id'=>$post->id])?>" class="list-group-item">
			<div class="row">
            		<div class="col-md-9"><?= html::encode($post->post_title)?></div>
            		<div class="col-md-3"><span class='glyphicon glyphicon-time pull-right'><?= html::encode($post->updated_date)?></span></div>
            </div>
			</a>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
	</div>
</div>
<!-- 最新文章结束 -->

<!-- 百度分享功能开始 -->
<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<!-- 百度分享功能结束 -->
    
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

