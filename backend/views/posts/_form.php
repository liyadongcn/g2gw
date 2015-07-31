<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Posts;
use common\models\Category;
use kartik\widgets\datepicker;
use kartik\widgets\DateTimePicker;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'post_title')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'post_content')->textarea(['rows' => 6]) ?>

    <?php 
//     echo $form->field($model, 'brand_id')->dropDownList(
//     		$model->getDropDownListData(MODEL_TYPE_BRAND),
//     		[
//     				'prompt'=>'选择涉及的品牌......'
    				
//    			 ]) 
    ?>
    
       <?php 
   // Usage with ActiveForm and model
    echo $form->field($model, 'brand_id')->widget(Select2::classname(), [
   		'data' => $model->getDropDownListData(MODEL_TYPE_BRAND),
   		'options' => ['placeholder' => '请选择商品品牌 ...'],
   		'pluginOptions' => [
   				'allowClear' => true
   		],
   ]); 
   
   ?> 
   			 
 <!-- 文章分类开始 -->
	 <div class="panel panel-default">
  		<div class="panel-heading">
   			<h3 class="panel-title">分类</h3>
  		</div>
  		<div class="panel-body">
		<?php $categories =ArrayHelper::map(Category::findAll(['model_type'=>$model->modelType()]),'id','name')?>
   		<?= $form->field($model, 'categories')->checkboxlist($categories) ?>
      	</div>
	</div>
<!-- 文章分类结束 -->

    <?php echo $form->field($model, 'post_status')->dropDownList(
    		$model->getDropDownListData(MODEL_TYPE_POSTS_STATUS),
    		[
    				'prompt'=>'状态'
    				
   			 ]) ?>

    <?php echo $form->field($model, 'url')->textInput(['maxlength' => 100]) ?>

    <?php //echo $form->field($model, 'created_date')->textInput() ?>

    <?php //echo $form->field($model, 'updated_date')->textInput() ?>

    <?php //echo $form->field($model, 'userid')->textInput() ?>
    
    <?php //echo $form->field($model, 'comment_count')->textInput() ?>

    <?php //echo $form->field($model, 'thumbsup')->textInput() ?>

    <?php //echo $form->field($model, 'thumbsdown')->textInput() ?>

    <?php //echo $form->field($model, 'effective_date')->textInput() ?>
    
    <?php echo $form->field($model, 'effective_date')->widget(DateTimePicker::className(),
    		[
    		//'value' => date('Y-M-d hh:ii', strtotime('+2 days')),
    		'options' => ['placeholder' => '选择开始日期...'],
    		'pluginOptions' => [
    			'format' => 'yyyy-mm-dd hh:ii:ss',
    			'todayHighlight' => true,
    			'autoclose'=>true
    		 ]
    		]) ?>

    <?php //echo $form->field($model, 'expired_date')->textInput() ?>
    
    <?php echo $form->field($model, 'expired_date')->widget(DateTimePicker::className(),
    		[
    		//'value' => date('Y-M-d hh:ii', strtotime('+2 days')),
    		'options' => ['placeholder' => '选择开始日期...'],
    		'pluginOptions' => [
    		 'format' => 'yyyy-mm-dd hh:ii:ss',
    		'todayHighlight' => true,
    		 'autoclose'=>true
    		]
    		]) ?>

    <?php //echo $form->field($model, 'view_count')->textInput() ?>
    
<!-- 图片显示与更新开始    -->
         <div class="panel panel-default">
  		<div class="panel-heading">
   			<h3 class="panel-title">图片</h3>
  		</div>
  		<div class="panel-body">
		  	<?php $album=$model->album;?>
			<?php if(!empty($album)):?>
			<div class="row">
				<?php foreach ($album as $image): ?>
				<div class="col-sm-6 col-md-3 col-lg-2"">
				<div class="thumbnail">
					<a href=<?= Url::to($model->url)?>>
						<?= html::img($image->filename,['class'=>'img-responsive  img-thumbnail center-block'])?>	
					</a>
				<div class="caption">						
					<p><a href=<?= Url::to(['album/delete','id'=>$image->id])?> class="btn btn-default btn-xs" role="button">删除</a>
					<?php if(!$image->is_default):?>
						<a href=<?= Url::to(['album/set-default','id'=>$image->id])?> class="btn btn-default btn-xs" role="button">设为默认图片</a>
					<?php endif;?>
					</p>
				</div>
				</div>
				</div>			
				<?php endforeach;?>
			</div>
			<?php endif;?>
    <?php 
    // Display an initial preview of files with caption
    // (useful in UPDATE scenarios). Set overwrite `initialPreview`
    // to `false` to append uploaded images to the initial preview.
    // Usage with ActiveForm and model
     echo $form->field($model, 'file[]')->widget(FileInput::classname(), [
     		'options'=>[
     				'multiple'=>true
     		],
     		'pluginOptions' => [
    			//'initialPreview'=>empty($initialPreview)?array():$initialPreview,
    			/* [
    				Html::img("/images/moon.jpg", ['class'=>'file-preview-image', 'alt'=>'The Moon', 'title'=>'The Moon']),
    		    	Html::img("/images/earth.jpg",  ['class'=>'file-preview-image', 'alt'=>'The Earth', 'title'=>'The Earth']),
    		    	], */
     		 	'initialCaption'=>"选择图片",
     		  	'overwriteInitial'=>FALSE,
     			'previewFileType' => 'image',
     			'showCaption' => false,
     			'showRemove' => true,
     			'showUpload' => false,
//      			'browseClass' => 'btn btn-primary btn-block',
//      			'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
//      			'browseLabel' =>  'Select Photo',
     			//'initialPreviewShowDelete'=>true,
     			//'initialPreviewConfig'=>empty($initialPreviewConfigs)?array():$initialPreviewConfigs,
     		]
     	]);
    // Multiple file/image selection with image only preview
    // Note for multiple file upload, the attribute name must be appended with
    // `[]` for PHP to be able to read an array of files
/*     echo $form->field($model, 'file[]')->fileInput( [
    		'options' => ['multiple' => true, 'accept' => 'image/*'],
    		'pluginOptions' => [
    				'previewFileType' => 'image',
    				'showUpload' => false,
    		]
    ]); */
    ?>
  		</div>
	</div>
<!-- 图片显示与更新结束 -->
    
    <!--  标签编辑开始 -->
     <div class="panel panel-default">
  		<div class="panel-heading">
   			<h3 class="panel-title">标签</h3>
  		</div>
  		<div class="panel-body">
  			<?php $tagMaps=$model->getTagMaps()->all();?>
  			<?php if($tagMaps):?>
  				<?php foreach ($tagMaps as $tagMap):?>  			
  					<span class="label label-success"><?= $tagMap->tag->name?>
  					<a href=<?= url::to(['tagmap/delete','id'=>$tagMap->id])?>>
  					<span class="glyphicon glyphicon-remove"><span>
  					</a>  
  					</span>&nbsp;
  				<?php endforeach;?>	
  			<?php endif;?>		
<!-- 			<span class="label label-primary">Primary</span> -->
<!-- 			<span class="label label-success">Success</span> -->
<!-- 			<span class="label label-info">Info</span> -->
<!-- 			<span class="label label-warning">Warning</span> -->
<!-- 			<span class="label label-danger">Danger</span> -->
  			<?= $form->field($model, 'tag_string')->label('')->textInput(['placeholder'=>'增加新标签，以空格为分割可以同时增加多个标签']) ?>
  		</div>
	</div>
<!--  标签编辑结束 -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
