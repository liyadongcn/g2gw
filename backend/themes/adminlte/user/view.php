<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use common\models\Relationships;
use common\models\RelationshipsMap;
use common\models\helper\TimeHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::$app->name.'-'.$model->nickname.'个人主页';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src=<?= html::encode($model->face); ?> alt="User profile picture">

              <h3 class="profile-username text-center"><?= html::encode($model->displayName)?></h3>

              <p class="text-muted text-center">Software Engineer</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>注册时间</b> <a class="pull-right"><?= html::encode(date('Y-m-d H:i:s',$model->created_at))?></a>                 
                </li>
                <li class="list-group-item">
                  <b>上次登录</b> <a class="pull-right"><?= html::encode(TimeHelper::getRelativeTime(Yii::$app->session->get('lastLoginTime')))?></a>
                </li>
                <li class="list-group-item">
                  <b>在线时长</b> <a class="pull-right"><?= html::encode(TimeHelper::formatTimeLength($model->onlineTime))?></a>
                </li>
              </ul>
              
              <a class="btn btn-primary btn-block" href=<?= Url::to(['update-password','id'=>$model->id]) ?>>
                            <span class="glyphicon glyphicon-pencil"></span>
                           <b> 修改登录密码</b>
                        </a>
              <a class="btn btn-primary btn-block btn-success" href=<?= Url::to(['update','id'=>$model->id]) ?>>
                            <span class="glyphicon glyphicon-cog"></span>
                            <b>修改个人信息</b>
                        </a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Education</strong>

              <p class="text-muted">
                B.S. in Computer Science from the University of Tennessee at Knoxville
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>

              <p class="text-muted">Malibu, California</p>

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
  <!-- 用户情况Tab页开始 -->
 
    <ul class="nav nav-tabs" role="tablist" id="feature-tab">
        <li class="active"><a href="#tab-chrome" role="tab" data-toggle="tab">收藏的品牌<span class="badge bg-yellow">4</span></a></li>
        <li><a href="#tab-firefox" role="tab" data-toggle="tab">收藏的精品</a></li>
        <li><a href="#tab-safari" role="tab" data-toggle="tab">收藏的活动</a></li>
        <li><a href="#tab-opera" role="tab" data-toggle="tab">发表的评论</a></li>
        <li><a href="#tab-ie" role="tab" data-toggle="tab">发表的文章及活动</a></li>
    </ul>

	<div class="tab-content">
        <div class="tab-pane active" id="tab-chrome">
            <!-- 用户收藏的品牌开始 -->
            <?php //Pjax::begin();?>
            <?php $starBrandProvider=$model->getRelationshipModels(Relationships::RELATIONSHIP_STAR, RelationshipsMap::MODEL_TYPE_BRAND)?>
            <?php //echo html::encode($starBrandProvider->totalCount)?>
            
			    <?php $brands=$starBrandProvider->models;?>
                    <?php if($brands):?>
                        <?php foreach ($brands as $brand):?>
                        <div class="post">
                        	<div class="user-block">
                        		<img class="img-circle img-bordered-sm" src="<?= html::encode($brand->logo)?>" alt="user image">
		                        <span class="username">
		                          <a href="<?= Url::to(['brand/view','id'=>$brand->id])?>"><?= html::encode($brand->en_name)?></a>
		                          <a href="<?= Url::to(['brand/remove-star','id'=>$brand->id])?>" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
		                        </span>
		                        <span class="description"><?= html::encode($brand->cn_name)?></span>
                            </div>
                        </div>
                        <?php endforeach;?>
                    
                    <?php endif;?>
              
                	<?php echo LinkPager::widget([
                        'pagination' => $starBrandProvider->getPagination(),
                        ]);
                    ?>
			 
			
            <?php //Pjax::end();?>
            <!-- 用户收藏的品牌结束 -->
        </div>
        <div class="tab-pane" id="tab-firefox">
                <!-- 用户收藏商品开始 -->
                <?php Pjax::begin();?>
                <?php $starGoodsProvider=$model->getRelationshipModels(Relationships::RELATIONSHIP_STAR, RelationshipsMap::MODEL_TYPE_GOODS);?>
                    <h3 class="panel-title">&nbsp;<span class="badge pull-right bg-yellow"><?= html::encode($starGoodsProvider->totalCount)?></span></h3>
                    <ul class="products-list product-list-in-box">
                        <?php $goods=$starGoodsProvider->models;?>
                        <?php if($goods):?>
                            <?php foreach ($goods as $goodsOne):?>
                            <li class="item">
                            	<div class="product-img">
                    				<img src="<?= html::encode($goodsOne->albumDefaultImg->filename)?>" alt="Product Image">
                  				</div>
                  				<div class="product-info">
                  					<a href=<?= Url::to(['goods/view','id'=>$goodsOne->id])?> class="product-title"><?= html::encode($goodsOne->title)?>
				                    </a>
				                    <a href="<?= Url::to(['goods/remove-star','id'=>$goodsOne->id])?>" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>                               
                                </div>
                            </li>
                            <?php endforeach;?>
                        <?php endif;?>
                    </ul>

                    <?php echo LinkPager::widget([
                            'pagination' => $starGoodsProvider->getPagination(),
                            ]);
                        ?>
                <?php Pjax::end();?>
                <!-- 用户收藏的商品结束 -->
        </div>
        <div class="tab-pane" id="tab-safari">
            <!-- 用户收藏的帖子开始 -->
            <?php Pjax::begin();?>
            <?php $starPostsProvider=$model->getRelationshipModels(Relationships::RELATIONSHIP_STAR, RelationshipsMap::MODEL_TYPE_POST);?>
                <h3 class="panel-title"><span class="badge pull-right"><?= html::encode($starPostsProvider->totalCount)?></span></h3>
                <ul class="posts-list post-list-in-box">
                    <?php $posts=$starPostsProvider->models;?>
                    <?php if($posts):?>
                        <?php foreach ($posts as $post):?>
                        <li class="item">
                        	<div class="post-img">
                    				<img src="<?= html::encode($post->albumDefaultImg->filename)?>" alt="Product Image">
                  			</div>
                  			<div class="post-info">
                  					<a href=<?= Url::to(['posts/view','id'=>$post->id])?> class="post-title"><?= html::encode($post->post_title)?>
				                    </a>
				                    <span class="post-description">
                          			<?= html::encode($post->updated_date)?>
                          			<a href="<?= Url::to(['posts/remove-star','id'=>$post->id])?>" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a> 
                        			</span>                   			
                            </div>                            
                        </li>
                        <?php endforeach;?>
                    <?php endif;?>
                </ul>
                <div class="box-footer">
                <?php echo LinkPager::widget([
                        'pagination' => $starPostsProvider->getPagination(),
                        ]);
                    ?>
                </div>
            <?php Pjax::end();?>
            <!-- 用户收藏的帖子结束 -->
        </div>
        <div class="tab-pane" id="tab-opera">
            <!-- 用户发表的所有评论开始 -->
           <?php Pjax::begin();?>
			<?php $dataProvider=$model->getComments();?>
			        <h3 class="panel-title"><span class="badge pull-right"><?= html::encode($dataProvider->totalCount)?></span></h3>
			        <?php $comments=$dataProvider->models;?>
			        <?php //var_dump($comments);?>
			        <?php if($comments):?>
			            <?php foreach ($comments as $comment):?>     
			          <div class="direct-chat-msg">
                      <div class="direct-chat-info clearfix">
<!--                         <span class="direct-chat-name pull-left">Alexander Pierce</span> -->
                        <span class="direct-chat-timestamp pull-right"><?= html::encode(TimeHelper::getRelativeTime($comment->created_date))?></span>
                      </div>
                      <!-- /.direct-chat-info -->
                      <img class="direct-chat-img" src=<?= html::encode($model->face); ?> alt="message user image"><!-- /.direct-chat-img -->
                      <div class="direct-chat-text">
                      		<a href="<?= Url::to([$comment->model_type.'/view','id'=>$comment->model_id])?>" >
                        	<?= html::encode($comment->content)?>
                            </a>
                      </div>
                      <!-- /.direct-chat-text -->
                    </div>
			            <?php endforeach;?>
			        <?php endif;?>
			        <?php echo LinkPager::widget([
			            'pagination' => $dataProvider->getPagination(),
			            ]);
			        ?>
			   <?php Pjax::end();?>
			<!-- 用户发表的所有评论结束 -->
        </div>
        <div class="tab-pane" id="tab-ie">
            <!-- 用户发表的所有贴子开始 -->
            <?php Pjax::begin();?>
            <?php $postsProvider=$model->getPosts();?>
                    <h3 class="panel-title"><span class="badge pull-right"><?= html::encode($postsProvider->totalCount)?></span></h3>
                <ul class="posts-list post-list-in-box">
                    <?php $posts=$postsProvider->models;?>
                    <?php //var_dump($comments);?>
                    <?php if($posts):?>
                        <?php foreach ($posts as $post):?>
                            <li class="item">
                        	<div class="post-img">
                        			<?php if($post->albumDefaultImg):?>
                    				<img src="<?= html::encode($post->albumDefaultImg->filename)?>" alt="Product Image">
                    				<?php endif;?>
                  			</div>
                  			<div class="product-info">
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
                <?php echo LinkPager::widget([
                        'pagination' => $postsProvider->getPagination(),
                        ]);
                    ?>
                 <?php Pjax::end();?>   
                 <!-- 用户发表的所有帖子结束 -->
            </div>            

<!-- 用户情况Tab页结束-->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    <?php //echo Html::encode($this->title) ?>
    
<!-- 个人头像开始 -->
    <?php //echo  html::img($model->face,['class'=>'img-circle']); ?>
<!-- 个人头像结束 -->
<!--  注册时间 开始 -->
    <?php //echo html::encode(date('Y-m-d H:i:s',$model->created_at))?>
<!-- 注册时间 结束 -->
<!-- 修改时间开始 -->
    <?php //echo html::encode(date('Y M D H:i:s',$model->updated_at));?>
<!-- 修改时间结束 -->


    <?php
//      echo  DetailView::widget([
//         'model' => $model,
//         'attributes' => [
//             //'id',
//             'username',
//             //'password',
//             'cellphone',
//             'email:email',
//             'face',
//             'nickname',
//             //'auth_key',
//             //'accessToken',
//             'created_at',
//             'updated_at',
//             //'password_hash',
//             //'password_reset_token',
//             //'status',
//             //'role',
//         ],
//     ]) 
     ?>

    <!-- Loading state -->
<!--     <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div> -->
    
</div>
