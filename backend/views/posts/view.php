<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\widgets\LinkPager;
use common\models\Comment;

/* @var $this yii\web\View */
/* @var $model common\models\Posts */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
            'post_title',
            'post_content:ntext',
        	'brand_id',
            'post_status',
            'url:url',
            'created_date',
            'updated_date',
            'userid',
            'comment_count',
            'thumbsup',
            'thumbsdown',
            'effective_date',
            'expired_date',
            'view_count',
        ],
    ]) ?>

</div>

     <div class="panel panel-default">
  		<div class="panel-heading">
   			<h3 class="panel-title">标签</h3>
  		</div>
  		<div class="panel-body">
  			<?php $tagMaps=$model->getTagMaps()->all();?>
  			<?php if($tagMaps):?>
  				<?php foreach ($tagMaps as $tagMap):?>  			
  					<span class="label label-success"><?= $tagMap->tag->name?></span>
  				<?php endforeach;?>	
  			<?php endif;?>		
<!-- 			<span class="label label-primary">Primary</span> -->
<!-- 			<span class="label label-success">Success</span> -->
<!-- 			<span class="label label-info">Info</span> -->
<!-- 			<span class="label label-warning">Warning</span> -->
<!-- 			<span class="label label-danger">Danger</span> -->
  		</div>
	</div>
    
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

     <?php $form = ActiveForm::begin(['action' => ['comment/create'],'method'=>'post']); ?>
    
    <?php $modelComment=new Comment();?>
    
    <?php echo $form->field($modelComment, 'model_type')->hiddenInput(['value'=>MODEL_TYPE_POSTS])->label(false) ?>
    
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
     
    <?php echo $form->field($modelSubComment, 'model_type')->hiddenInput(['value'=>MODEL_TYPE_POSTS])->label(false) ?>
    
    <?php echo $form->field($modelSubComment, 'model_id')->hiddenInput(['value'=>$model->id])->label(false)  ?>
     
    <?php echo $form->field($modelSubComment, 'parent_id')->hiddenInput(['class'=>'parent_id'])->label(false) ?>

    <?php echo $form->field($modelSubComment, 'content')->textarea(['rows' =>3])->label(false) ?>
    
    <div class="form-group">
        <?= Html::submitButton('回复评论', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
