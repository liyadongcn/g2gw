<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Album;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="goods-view">

	<h1><?php //echo  Html::encode($this->title) ?></h1>

	<div class="action">
		<span class="user"><span class="glyphicon glyphicon-info-sign"></span>商品编号：<?= html::encode($model->code)?></span>
		<span class="time"><span class="glyphicon glyphicon-time"></span> <?= html::encode($model->updated_date)?></span>
		<span class="views"><span class="glyphicon glyphicon-eye-open"></span><?= Html::encode($model->view_count) ?>次浏览</span>
		<span class="comments"><a href="#comments"><span
				class="glyphicon glyphicon-comment"></span> <?= Html::encode($model->comment_count) ?>条评论</a></span>
		<span class="favourites"><a href="<?= Url::to(['star','id' => $model->id])?>"
			data-toggle="tooltip" data-placement="top" title="收藏"><span
				class="glyphicon glyphicon-star"></span> <em><?= Html::encode($model->star_count) ?></em></a></span>
		<span class="vote"><a class="up"
			href="<?= Url::to(['thumbsup','id' => $model->id])?>" title=""
			data-toggle="tooltip" data-original-title="顶"><span
				class="glyphicon glyphicon-thumbs-up"></span> <em><?= Html::encode($model->thumbsup) ?></em></a><a
			class="down" href="<?= Url::to(['thumbsdown','id' => $model->id])?>"
			title="" data-toggle="tooltip" data-original-title="踩"><span
				class="glyphicon glyphicon-thumbs-down"></span> <em><?= Html::encode($model->thumbsdown) ?></em></a></span>
	</div>

	<div class="jumbotron ">
		<h1 class='text-left'><?= Html::encode($model->title) ?><small></small>
		</h1>
		<p class='text-left'><?= Html::encode($model->description) ?></p>
		<p class='text-left'>
			<a class="btn btn-primary btn-lg"
				href="<?= Html::encode($model->url) ?>" role="button">去购买</a>
		</p>
	</div>

	<!-- 商品品牌开始 -->
	<div>
	<?= Html::encode($model->brand->en_name)?>
	</div>
	<!-- 商品品牌结束 -->

	<!-- 历史价格列表开始 -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">历史价格</h3>
		</div>
		<div class="panel-body">
			<ul class="list-group">
			<?php $priceHistory=$model->pricehistory?>
			<?php if($priceHistory):?>
			<?php foreach ($priceHistory as $price):?>
			<div class="list-group-item">
				<?= html::encode($price->market_price)?>
				<?= html::encode($price->real_price)?>
				<?= html::encode($price->quotation_date)?>
			</div>
			<?php endforeach;?>
			<?php endif;?>
			</ul>
		</div>
	</div>
	<!-- 历史价格列表结束 -->

	<!-- 商品图片列表开始 -->
	<?php
		$album=$model->album;
		if(!empty($album)){
			echo '<div class="row">';			
			foreach ($album as $image){
				echo '<div class="col-sm-6 col-md-3 col-lg-2"">';
				echo '<div class="thumbnail">';
				echo '<img src="'.$image->filename.'" class="img-responsive img-thumbnail" alt="Responsive image" width="200">';
				echo '<div class="caption">';
				//echo '<h3>Thumbnail label</h3>';
				//echo '<p>...</p>';
				//echo '<a href="index.php?r=album/delete&id='.$image->id.'" class="btn btn-default btn-xs" role="button">删除</a></p>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}		
			echo '</div>';
		}
	?>
<!-- 商品图片列表结束 -->
   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'brand_id',
            'code',
            'description:ntext',
            'thumbsup',
            'thumbsdown',
            'url:url',
            'title',
            'comment_status',
            'comment_count',
            'created_date',
            'updated_date',
            'star_count',
            'recomended_count',
            'view_count',
        ],
    ]) ?>
    
<!-- 商品分类列表开始 -->
	<div class='goods-category'>
	<?php $categoryMaps=$model->getCategoryMap()->all();?>
		<?php if($categoryMaps):?>
			<?php foreach ($categoryMaps as $categoryMap): ?>
<!-- 			echo $this->renderAjax('@app/views/category-map/view.php',['model'=>$categoryMap]); -->
		<blockquote class="bg-primary">
			<p><?= $categoryMap->category->name?></p>
		</blockquote>
			<?php endforeach;?>
		<?php endif;?>
	</div>
	<!-- 商品分类列表结束	 -->


	<div class='goods-comment_status'>
		<blockquote class="bg-primary">
		<?php 
			echo $model->getDropDownListData('comment_status')[$model->comment_status];
		?>
	  
	
	</div>
	</blockquote>

</div>

<!-- 商品标签列表开始 -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">标签</h3>
	</div>
	<div class="panel-body">
  			<?php 
  				$tagMaps=$model->getTagMaps()->all();
  				foreach ($tagMaps as $tagMap)
  			:?>
  				<a href="<?= Url::to(['goods/search-by-tag','tagid' =>  $tagMap->tag->id])?>"><span class="label label-success"><?= $tagMap->tag->name?></span></a>
  			<?php endforeach;?>			
<!-- 			<span class="label label-primary">Primary</span> -->
		<!-- 			<span class="label label-success">Success</span> -->
		<!-- 			<span class="label label-info">Info</span> -->
		<!-- 			<span class="label label-warning">Warning</span> -->
		<!-- 			<span class="label label-danger">Danger</span> -->
	</div>
</div>
<!-- 商品标签列表结束	 -->

<!-- 相关商品开始 -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">相关</h3>
	</div>
	<div class="panel-body">
		<ul class="list-group">
	<?php $relatedGoods=$model->getRelatedGoods(5)->all();?>
	<?php //var_dump($relatedBrands); die();?>
	<?php if($relatedGoods):?>
		<?php foreach ($relatedGoods as $goods):?>
			<a href="<?= Url::to(['goods/view','id'=>$goods->id])?>"
				class="list-group-item"><?= html::encode($goods->title)?></a>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
	</div>
</div>
<!-- 相关商品结束 -->

<!-- 评论列表开始 -->
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
<!-- 评论列表结束 -->
<!-- 评论发表框开始 -->
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
<!-- 评论发表结束 -->