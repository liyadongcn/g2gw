<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\widgets\LinkPager;
use common\models\Relationships;
use common\models\RelationshipsMap;
use common\models\helper\TimeHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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

<!-- 用户详情展示开始 -->

<div class="panel panel-default">
    <div class="panel-body">
        <div class="media media-profile">
            <div class="media-left">
                <img class="media-object" src=<?= html::encode($model->face); ?> alt=<?= html::encode($model->username)?>></div>
            <div class="media-body">
                <h3 class="media-heading">
                    <span class="glyphicon glyphicon-user"></span>
                    <?= html::encode($model->username)?>
                    <small>
                        第 <em>27646</em> 位会员
                    </small>
                    <span class="pull-right">
                        <a class="btn btn-xs btn-success btn-follow" href="/follow?id=27646">
                            <span class="glyphicon glyphicon-plus"></span>
                            关注
                        </a>
                        <a class="btn btn-xs btn-primary" href="/user/message/create?id=27646">
                            <span class="glyphicon glyphicon-envelope"></span>
                            发私信
                        </a>
                    </span>
                </h3>

                <p>
                    <span class="glyphicon glyphicon-map-marker"></span>
                    上海
                    <span class="glyphicon glyphicon-gift"></span>
                    2051-05-01
                </p>

                <p>
                    <span class="glyphicon glyphicon-envelope"></span>
                    <?= html::mailto($model->email)?>
                    <span class="fa fa-group"></span>
                    未设置
                </p>

                <p>
                    <span class="glyphicon glyphicon-calendar"></span>
                    注册时间：<?= html::encode(date('Y-m-d H:i:s',$model->created_at))?>
                </p>
                <p>
                    <span class="glyphicon glyphicon-log-in"></span>
                    最后登录：3分钟前
                </p>
                 <p>  
                    <span class="glyphicon glyphicon-dashboard"></span>
                    在线时长：52小时22分
                </p>

                <p>
                    <span class="glyphicon glyphicon-pencil"></span>
                    这家伙有点懒，还没写个性签名！
                </p>
            </div>

        </div>
    </div>
</div>

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
<!-- 用户详情展示结束 -->
    
<!-- 用户发表的所有评论开始 -->
<?php $dataProvider=$model->getComments();?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">发表的评论<span class="badge pull-right"><?= html::encode($dataProvider->totalCount)?></span></h3>
    </div>
    <div class="panel-body">
        <ul class="list-group">
        <?php $comments=$dataProvider->models;?>
        <?php //var_dump($comments);?>
        <?php if($comments):?>
        	<?php foreach ($comments as $comment):?>
                <a href="<?= Url::to([$comment->model_type.'/view','id'=>$comment->model_id])?>" class="list-group-item">
                <div class="row">
                    <div class="col-md-9"><?= html::encode($comment->content)?></div>
                    <div class="col-md-3"><span class='glyphicon glyphicon-time pull-right'><?= html::encode(TimeHelper::getRelativeTime($comment->created_date))?></span></div>
                </div>
                </a>
        	<?php endforeach;?>
        <?php endif;?>
        </ul>
      
        <?php echo LinkPager::widget([
            'pagination' => $dataProvider->getPagination(),
            ]);
        ?>
       
    </div>
    
</div>
<!-- 用户发表的所有评论结束 -->
	
<!-- 用户发表的所有贴子开始 -->
<?php $postsProvider=$model->getPosts();?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">发表的文章及活动<span class="badge pull-right"><?= html::encode($postsProvider->totalCount)?></span></h3>
    </div>
    <div class="panel-body">
    <ul class="list-group">
        <?php $posts=$postsProvider->models;?>
        <?php //var_dump($comments);?>
        <?php if($posts):?>
            <?php foreach ($posts as $post):?>
                <a href="<?= Url::to(['posts/view','id'=>$post->id])?>" class="list-group-item">
                <div class="row">
                    <div class="col-md-9"><?= html::encode($post->post_title)?></div>
                    <div class="col-md-3"><span class='glyphicon glyphicon-time pull-right'><?= html::encode(TimeHelper::getRelativeTime($post->created_date))?></span></div>
                </div>
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
<!-- 用户发表的所有帖子结束 -->


<!-- 用户收藏的品牌开始 -->
<?php $starBrandProvider=$model->getRelationshipModels(Relationships::RELATIONSHIP_STAR, RelationshipsMap::MODEL_TYPE_BRAND);?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">收藏的品牌<span class="badge pull-right"><?= html::encode($starBrandProvider->totalCount)?></span></h3>
    </div>
    <div class="panel-body">
    <ul class="list-group">
    	
    	<?php $brands=$starBrandProvider->models?>
        <?php if($brands):?>
            <?php foreach ($brands as $brand):?>
            <li class="list-group-item">
                <a href="<?= Url::to(['brand/view','id'=>$brand->id])?>"><?= html::encode($brand->en_name)?></a>
                <span class="pull-right"><a href="<?= Url::to(['brand/remove-star','id'=>$brand->id])?>">取消收藏</a></span>
            </li>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
    </div>
    <div class="panel-footer">
    	<span>
    	<?php echo LinkPager::widget([
            'pagination' => $starBrandProvider->getPagination(),
            ]);
        ?>
    	</span>
    </div>
</div>
<!-- 用户收藏的品牌结束 -->

<!-- 用户收藏的帖子开始 -->
<?php $starPostsProvider=$model->getRelationshipModels(Relationships::RELATIONSHIP_STAR, RelationshipsMap::MODEL_TYPE_POST);?>
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
                <div class="row">
                    <div class="col-md-9"><a href="<?= Url::to(['posts/view','id'=>$post->id])?>"><?= html::encode($post->post_title)?></a></div>
                    <div class="col-md-3"><span class="pull-right"><a href="<?= Url::to(['posts/remove-star','id'=>$post->id])?>">取消收藏</a></span></div>
                </div>
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
<!-- 用户收藏的帖子结束 -->

<!-- 用户收藏商品开始 -->
<?php $starGoodsProvider=$model->getRelationshipModels(Relationships::RELATIONSHIP_STAR, RelationshipsMap::MODEL_TYPE_GOODS);?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">收藏的商品<span class="badge pull-right"><?= html::encode($starGoodsProvider->totalCount)?></span></h3>
    </div>
    <div class="panel-body">
    <ul class="list-group">
    	<?php $goods=$starGoodsProvider->models;?>
        <?php if($goods):?>
            <?php foreach ($goods as $goodsOne):?>
            <li class="list-group-item">
                <div class="row">
                    <div class="col-md-9"><a href="<?= Url::to(['goods/view','id'=>$goodsOne->id])?>"><?= html::encode($goodsOne->title)?></a></div>
                    <div class="col-md-3"><span class="pull-right"><a href="<?= Url::to(['goods/remove-star','id'=>$goodsOne->id])?>">取消收藏</a></span></div>
                </div>
            </li>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
    </div>
    <div class="panel-footer">
        	<span>
    	<?php echo LinkPager::widget([
            'pagination' => $starGoodsProvider->getPagination(),
            ]);
        ?>
    	</span>
    </div>
</div>
<!-- 用户收藏的商品结束 -->


</div>
