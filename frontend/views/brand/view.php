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

<!-- 相关品牌开始 -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">相关</h3>
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

