<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use backend\assets\AppAsset;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */

//AppAsset::register($this);
//$this->registerCssFile('@web/css/font-awesome.min.css',['depends'=>['api\assets\AppAsset']]);
$this->registerJsFile('@web/js/yiichina.js');//,['depends'=>['app\assets\AppAsset']]);

$this->title = $model->en_name;
$this->params['breadcrumbs'][] = ['label' => 'Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="brand-view">

	<div class="jumbotron ">
		<h1 class='text-left'><?= Html::encode($model->en_name) ?></h1>
		<p class='text-left'><?= Html::encode($model->introduction) ?></p>
		<p class='text-left'>
			<a class="btn btn-primary btn-lg"
				href="<?= Html::encode($model->baidubaike) ?>" role="button">Learn
				more</a>
		</p>

	</div>
	<?php Pjax::begin();?>
    <p class='text-center'>
		<a data-pjax="0" href="<?= Url::to(['thumbsup','id' => $model->id])?>">
			<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
		</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsup) ?></span>
		&nbsp;| <a data-pjax="true"
			href="<?= Url::to(['thumbsdown','id' => $model->id])?>"> <span
			class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
		</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsdown) ?></span>
		&nbsp;| <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
		<span class="badge" aria-hidden="true"><?= Html::encode($model->comment_count) ?></span>
		&nbsp;| <span class="glyphicon glyphicon-eye-open"></span> <span
			class="badge"><?= Html::encode($model->view_count) ?></span>
		&nbsp;| <a href="<?= Url::to(['brand/star','id' => $model->id])?>">
			<span class="glyphicon glyphicon-star"></span>
			</a> <span class="badge"><?= Html::encode($model->star_count) ?></span>
	</p>
	<?php Pjax::end();?>
	
	<!-- 		去电商网站购物开始 -->
		<p class="text-center">
				<?php $ecommerces=$model->ecommerces;?>
				<?php if ($ecommerces) :?>
				<?php foreach ($ecommerces as $ecommerce) :?>
					<?php if($ecommerce->accept_order):?>
					<a class="btn btn-success"
							href="<?= html::encode($ecommerce->website);?>" role="button"><?= html::encode($ecommerce->name);?></a>
					<?php else :?>
					<a class="btn btn-warning"
							href="<?= html::encode($ecommerce->website);?>" role="button"><?= html::encode($ecommerce->name);?></a>
					<?php endif;?>
				<?php endforeach;?>
				<?php endif;?>
		</p>
<!-- 		去电商网站结束 -->

    <?php //echo  DetailView::widget([
//         'model' => $model,
//         'attributes' => [
//             'id',
//             'en_name',
//             'country_code',
//             'logo',
//             'cn_name',
//             'introduction:ntext',
//             'baidubaike',
//             'thumbsup',
//             'thumbsdown',
//             'company_id',
//             'comment_count',
//             'view_count',
//         ],
//     ]) ?>

</div>

<!-- 标签开始 -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">标签</h3>
	</div>
	<div class="panel-body">
  			<?php $tagMaps=$model->getTagMaps()->all();?>
  			<?php if($tagMaps):?>
  				<?php foreach ($tagMaps as $tagMap):?>  			
  					<a href="<?= Url::to(['brand/search-by-tag','tagid' =>  $tagMap->tag->id])?>"><span class="label label-success"><?= $tagMap->tag->name?></span></a>
  				<?php endforeach;?>	
  			<?php endif;?>		
<!-- 			<span class="label label-primary">Primary</span> -->
		<!-- 			<span class="label label-success">Success</span> -->
		<!-- 			<span class="label label-info">Info</span> -->
		<!-- 			<span class="label label-warning">Warning</span> -->
		<!-- 			<span class="label label-danger">Danger</span> -->
	</div>
</div>
<!-- 标签结束 -->

<!-- 相关发帖开始 -->
<?php $postsProvider=$model->getRelatedPosts();?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">相关的促销活动及文章<span class="badge pull-right"><?= html::encode($postsProvider->totalCount)?></span></h3>
    </div>
    <div class="panel-body">
    <ul class="list-group">
        <?php $posts=$postsProvider->models;?>
        <?php //var_dump($comments);?>
        <?php if($posts):?>
            <?php foreach ($posts as $post):?>
                <a href="<?= Url::to(['posts/view','id'=>$post->id])?>"
                class="list-group-item"><?= html::encode($post->post_title)?>
                <span class='glyphicon glyphicon-time pull-right'><?= html::encode($post->updated_date)?></span>
                </a>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
    </div>
    <div class="panel-footer">
    	<span>
    	<?php echo LinkPager::widget([
            'pagination' => $postsProvider->getPagination(),
            ]);
        ?>
    	</span>
    </div>
</div>
<!-- 相关发帖结束 -->

<!-- 相关品牌开始 -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">相关品牌</h3>
	</div>
	<div class="panel-body">
	<ul class="list-group">
	<?php $relatedBrands=$model->getRelatedBrands(5)->all();?>
	<?php //var_dump($relatedBrands); die();?>
	<?php if($relatedBrands):?>
		<?php foreach ($relatedBrands as $relatedBrand):?>
			<a href="<?= Url::to(['brand/view','id'=>$relatedBrand->id])?>"
				class="list-group-item"><?= html::encode($relatedBrand->en_name)?></a>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
	</div>
</div>
<!-- 相关品牌结束 -->

<!-- 百度分享功能开始 -->
<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more">分享到：</a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间">QQ空间</a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博">新浪微博</a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博">腾讯微博</a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网">人人网</a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信">微信</a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{"bdSize":16},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
<!-- 百度分享功能结束 -->

<!-- 评论开始 -->
<div id="comments">
	<div class="page-header">
		<h2>
			共 <em><?= Html::encode($model->comment_count)?></em> 条评论
		</h2>
		<ul id="w0" class="nav nav-tabs nav-sub">
			<li class="active"><a href="/tutorial/332#comments">默认排序</a></li>
			<li><a href="/tutorial/332?sort=desc#comments">最后评论</a></li>
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

    <?php // echo $form->field($model, 'model_type')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'model_id')->textInput() ?>

    <?php // echo $form->field($model, 'approved')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'thumbsup')->textInput() ?>

    <?php // echo $form->field($model, 'thumbsdown')->textInput() ?>

    <?php echo $form->field($model->comment, 'content')->textarea(['rows' =>3])->label(false) ?>

    <?php // echo $form->field($model, 'created_date')->textInput() ?>

    <?php // echo $form->field($model, 'updated_date')->textInput() ?>

    <?php // echo $form->field($model, 'userid')->textInput() ?>

    <?php // echo $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'author_ip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('回复评论', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

