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
    
     <div class="jumbotron " >
	  <h1 class='text-left'><?= Html::encode($model->title) ?></h1>
	  <p class='text-left'><?= Html::encode($model->description) ?></p>
	  <p class='text-left'><a class="btn btn-primary btn-lg" href="<?= Html::encode($model->url) ?>" role="button">去购买</a></p>
	</div>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
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
				    <p ><?= $categoryMap->category->name?></p>
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
  				<span class="label label-success"><?= $tagMap->tag->name?></span>
  			<?php endforeach;?>			
<!-- 			<span class="label label-primary">Primary</span> -->
<!-- 			<span class="label label-success">Success</span> -->
<!-- 			<span class="label label-info">Info</span> -->
<!-- 			<span class="label label-warning">Warning</span> -->
<!-- 			<span class="label label-danger">Danger</span> -->
  		</div>
	</div>
<!-- 商品标签列表结束	 -->
	
<!-- 评论列表开始 -->
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
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <?php //隐藏的回复框?>
    
     <?php $form = ActiveForm::begin(['options'=>['class' => 'reply-form hidden']]); ?>

    <?php  echo $form->field($model->comment, 'parent_id')->hiddenInput() ?>

    <?php // echo $form->field($model, 'model_type')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'model_id')->textInput() ?>

    <?php // echo $form->field($model, 'approved')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'thumbsup')->textInput() ?>

    <?php // echo $form->field($model, 'thumbsdown')->textInput() ?>

    <?php echo $form->field($model->comment, 'content')->textarea(['rows' =>3]) ?>

    <?php // echo $form->field($model, 'created_date')->textInput() ?>

    <?php // echo $form->field($model, 'updated_date')->textInput() ?>

    <?php // echo $form->field($model, 'userid')->textInput() ?>

    <?php // echo $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?php // echo $form->field($model, 'author_ip')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<!-- 评论发表结束 -->