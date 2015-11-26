<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use backend\assets\AppAsset;
use yii\widgets\LinkPager;
use common\models\helper\BrowserHelper;
use common\advertisement\ADManager;
use common\models\Comment;

/* @var $this yii\web\View */
/* @var $model common\models\Brand */

//AppAsset::register($this);
//$this->registerCssFile('@web/css/font-awesome.min.css',['depends'=>['api\assets\AppAsset']]);
$this->registerJsFile('@web/js/yiichina.js');//,['depends'=>['app\assets\AppAsset']]);

$this->title =  Yii::$app->name.'-'.$model->en_name.$model->cn_name;
$this->params['breadcrumbs'][] = ['label' => 'Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="brand-view">

	<div class="jumbotron ">
		<img class="profile-brand-img img-responsive img-circle" src="<?= Html::encode($model->logo) ?>" alt="User1 profile picture">
		<h1 class='text-left'><?= Html::encode($model->en_name) ?> <small><?= Html::encode($model->cn_name) ?></small></h1>
		<p class='text-left'><?= Html::encode($model->introduction) ?></p>
		<p class='text-left'>
			<a class="btn btn-default btn-sm" target="_blank"
				href="<?= Html::encode($model->baidubaike) ?>" role="button">更多...</a>
			<?php if($model->isStared()):?>
				<a class="btn btn-primary btn-sm" href="<?= Url::to(['remove-star','id' => $model->id])?>"
					data-toggle="tooltip" data-placement="top" title="取消收藏"><span
					class="glyphicon glyphicon-star">取消收藏</span> </a>
			<?php else :?>
				<a class="btn btn-primary btn-sm" href="<?= Url::to(['star','id' => $model->id])?>"
					data-toggle="tooltip" data-placement="top" title="收藏"><span
					class="glyphicon glyphicon-star-empty">收藏</span> </a>
			<?php endif;?>
		</p>

	</div>
		<div class="box box-primary">
            <div class="box-body box-profile">
	         <img class="profile-brand-img img-responsive img-circle" src="<?= Html::encode($model->logo) ?>" alt="User1 profile picture">
			<h3 class='text-center  profile-username'><?= Html::encode($model->en_name) ?> </h3> 
			<p class="text-muted text-center"><?= Html::encode($model->cn_name) ?></p>
			<p class='text-left'><?= Html::encode($model->introduction) ?></p>
			<p class='text-left'>
				<a class="btn btn-default" target="_blank"
					href="<?= Html::encode($model->baidubaike) ?>" role="button">更多...</a>
				<?php if($model->isStared()):?>
					<a class="btn btn-primary" href="<?= Url::to(['remove-star','id' => $model->id])?>"
						data-toggle="tooltip" data-placement="top" title="取消收藏"><span
						class="glyphicon glyphicon-star">取消收藏</span> </a>
				<?php else :?>
					<a class="btn btn-primary" href="<?= Url::to(['star','id' => $model->id])?>"
						data-toggle="tooltip" data-placement="top" title="收藏"><span
						class="glyphicon glyphicon-star-empty">收藏</span> </a>
				<?php endif;?>
			</p>
            <hr>
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
	
	<!-- 		去电商网站购物开始 -->
		<p class="text-center">
				<?php $ecommerces=$model->ecommerces;?>
				<?php if ($ecommerces) :?>
				<?php foreach ($ecommerces as $ecommerce) :?>
					<?php empty($ecommerce->link_promotion) ? $link=$ecommerce->website : $link=$ecommerce->link_promotion;?>
					<?php if($ecommerce->accept_order):?>
					<a class="btn btn-success" target="_blank"
							href="<?= html::encode($link);?>" role="button"><?= html::encode($ecommerce->name);?></a>
					<?php else :?>
					<a class="btn btn-warning" target="_blank"
							href="<?= html::encode($link);?>" role="button"><?= html::encode($ecommerce->name);?></a>
					<?php endif;?>
				<?php endforeach;?>
				<?php endif;?>
		</p>
<!-- 		去电商网站结束 --> 
            </div>
            <!-- /.box-body -->
          </div>

	

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
<?php $tagMaps=$model->getTagMaps()->all();?>
<?php if($tagMaps):?>  
	<div class="box box-primary ">
            <div class="box-header with-border">
              <h3 class="box-title"> 标签</h3>
              <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="<?= html::encode(count($tagMaps))?>个标签" class="badge bg-light-blue"><?= html::encode(count($tagMaps))?></span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>                
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: block;">            
  							
  				<?php foreach ($tagMaps as $tagMap):?>  			
  					<a href="<?= Url::to(['brand/search-by-tag','tagid' =>  $tagMap->tag->id])?>"><span class="label label-success"><?= $tagMap->tag->name?></span></a>
  				<?php endforeach;?>	
  			
  					
            </div>
            <!-- /.box-body -->
         </div>
<?php endif;?>
<!-- 标签结束 -->

<!-- 广告条开始 -->
<?php if(BrowserHelper::is_mobile()):?>
<!-- mobile device -->
<?php echo ADManager::getAd(ADManager::AD_JD, ADManager::AD_MOBILE, ADManager::AD_SIZE_336_280);?>
<?php else:?>
<!-- pc device -->
<?php echo ADManager::getAd(ADManager::AD_JD, ADManager::AD_PC, ADManager::AD_SIZE_960_90);?>
<?php endif;?>
<!-- 广告条结束 -->

<!-- 相关发帖开始 -->
<?php $postsProvider=$model->getRelatedPosts();?>
		<div class="box box-primary ">
            <div class="box-header with-border">
              <h3 class="box-title"> 相关的促销活动及文章</h3>
              <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="<?= html::encode($postsProvider->totalCount)?>个标签" class="badge bg-light-blue"><?= html::encode($postsProvider->totalCount)?></span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>                
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: block;">            
  				<ul class="posts-list post-list-in-box">
                    <?php $posts=$postsProvider->models;?>
                    <?php if($posts):?>
                        <?php foreach ($posts as $post):?>
                            <li class="item">
                        	<div class="post-img">
                        			<?php if($post->albumDefaultImg):?>
                    				<img src="<?= html::encode($post->albumDefaultImg->filename)?>" alt="Product Image">
                    				<?php endif;?>
                  			</div>
                  			<div class="post-info">
                  					<a href=<?= Url::to(['posts/view','id'=>$post->id])?> class="post-title"><?= html::encode($post->post_title)?>
				                    </a>
				                    <span class="post-description">
                          			<?= html::encode($post->updated_date)?>
                        			</span>
                            </div>                            
                        	</li>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>  					
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="box-tools">
		    	<?php echo LinkPager::widget([
		            'pagination' => $postsProvider->getPagination(),
		    		'options' => ['class'=>'pagination pagination-sm inline']
		            ]);
		        ?>
		       </div>
         	</div>
         </div>
<!-- 相关发帖结束 -->

<!-- 相关品牌开始 -->
<?php $relatedBrands=$model->getRelatedBrands(8)->all();?>
<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">相关品牌</h3>
                  <div class="box-tools pull-right">
                    <span class="label label-danger"> <?= html::encode(count($relatedBrands))?>个相关品牌</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                  <?php if($relatedBrands):?>
                  <?php foreach ($relatedBrands as $relatedBrand):?>
                    <li>
                      <img class="profile-brand-img img-responsive img-circle" src="<?= html::encode($relatedBrand->logo)?>" alt="User Image">
                      <a href="<?= Url::to(['brand/view','id'=>$relatedBrand->id])?>"
						class="users-list-name"><?= html::encode($relatedBrand->en_name)?></a>
                      <span class="users-list-date"><?= html::encode($relatedBrand->cn_name)?></span>
                    </li>
                  <?php endforeach;?>
                  <?php endif;?>
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="javascript::" class="uppercase">View All Users</a>
                </div>
                <!-- /.box-footer -->
              </div>
<!-- 相关品牌结束 -->

<!-- 广告条开始 -->
<?php if(BrowserHelper::is_mobile()):?>
<!-- mobile device -->
<?php echo ADManager::getAd(ADManager::AD_TAOBAO, ADManager::AD_MOBILE, ADManager::AD_SIZE_320_90);?>
<?php else:?>
<!-- pc device -->
<?php echo ADManager::getAd(ADManager::AD_TAOBAO, ADManager::AD_PC, ADManager::AD_SIZE_1000_90);?>
<?php endif;?>
<!-- 广告条结束 -->

<!-- 百度分享功能开始 -->
<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
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

    <?php $form = ActiveForm::begin(['action' => ['comment/create'],'method'=>'post']); ?>

     <?php $modelComment=new Comment();?>
    
    <?php echo $form->field($modelComment, 'model_type')->hiddenInput(['value'=>MODEL_TYPE_BRAND])->label(false) ?>
    
    <?php echo $form->field($modelComment, 'model_id')->hiddenInput(['value'=>$model->id])->label(false)  ?>
    
    <?php // echo $form->field($model, 'parent_id')->textInput() ?>

    <?php // echo $form->field($model, 'model_type')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'model_id')->textInput() ?>

    <?php // echo $form->field($model, 'approved')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'thumbsup')->textInput() ?>

    <?php // echo $form->field($model, 'thumbsdown')->textInput() ?>

    <?php echo $form->field($modelComment, 'content')->textarea(['rows' => 6]) ?>

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
    
     <?php $form = ActiveForm::begin(['action' => ['comment/create'],'method'=>'post','options'=>['class' => 'reply-form hidden']]); ?>

     <?php $modelSubComment=new Comment();?>
     
    <?php echo $form->field($modelSubComment, 'model_type')->hiddenInput(['value'=>MODEL_TYPE_BRAND])->label(false) ?>
    
    <?php echo $form->field($modelSubComment, 'model_id')->hiddenInput(['value'=>$model->id])->label(false)  ?>
     
    <?php echo $form->field($modelSubComment, 'parent_id')->hiddenInput(['class'=>'parent_id'])->label(false) ?>

    <?php echo $form->field($modelSubComment, 'content')->textarea(['rows' =>3])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('回复评论', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

