<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use common\models\Brand;
//use common\models\Album;
use yii\helpers\ArrayHelper;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
//use yii\widgets\InputWidget;

/* 
 * 数据不应该出现在view里，以下代码只用作上传插件时参考
 * @author wintermelon
 * @since 1.0
 * 
 * if(!$model->isNewRecord){
	$model->file=Album::findAll(['model_id'=>$model->id,'model_type'=>Album::MODEL_TYPE_GOODS]);
	foreach ($model->file as $file){
		$initialPreview[]=Html::img($file->filename, ['class'=>'file-preview-image']);//, 'alt'=>'$file->filename', 'title'=>'The Moon'
		$initialPreviewConfig['caption']=$file->filename;
		$initialPreviewConfig['width']='50px';
		$initialPreviewConfig['url']='index.php?r=album/delete&id='.$file->id;
		$initialPreviewConfig['key']=$file->id;
		//$initialPreviewConfig['extra']=$file->filename;
		//$initialPreviewConfigs[]=$initialPreviewConfig;
	}
	//var_dump($initialPreviewConfigs);
} */

/* @var $this yii\web\View */
/* @var $model common\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php //echo $form->field($model, 'id')->textInput() ?>

    <?php /* echo $form->field($model, 'brand_id')->dropDownList(
    												ArrayHelper::map(Brand::find()->all(),'id','en_name'),
    		                                       ['prompt' => '请选择商品品牌']
    		) */ ?>
    		
   <?php 
   // Usage with ActiveForm and model
    echo $form->field($model, 'brand_id')->widget(Select2::classname(), [
   		'data' => $model->getDropDownListData('brand_id'),
   		'options' => ['placeholder' => '请选择商品品牌 ...'],
   		'pluginOptions' => [
   				'allowClear' => true
   		],
   ]); 
   
   ?> 



    <?php echo $form->field($model, 'code')->textInput(['maxlength' => 30]) ?>
    
     <?php echo $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>
     
     <?php echo $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

    <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    
     <?php //echo $form->field($model, 'comment_status')->textInput(['maxlength' => 20]) ?>
    <?php  echo $form->field($model, 'comment_status')->dropDownList(
    												$model->getDropDownListData('comment_status'),
    		                                       ['prompt' => '请选择评论状态']
    		) 
    ?>
    
    <?php //echo $form->field($model, 'file[]')->fileInput(['multiple' => true]) ?>
    
<!-- 图片显示与上传开始 -->
     <div class="panel panel-default">
  		<div class="panel-heading">
   			<h3 class="panel-title">图片</h3>
  		</div>
  		<div class="panel-body">
  			 <?php
  			 $album=$model->getAlbum();
		if(!empty($album)){
			echo '<div class="row">';			
			foreach ($album as $image){
				echo '<div class="col-sm-6 col-md-3 col-lg-2"">';
				echo '<div class="thumbnail">';
				echo '<img src="'.$image->filename.'" class="img-responsive img-thumbnail" alt="Responsive image" width="200">';
				echo '<div class="caption">';
				//echo '<h3>Thumbnail label</h3>';
				//echo '<p>...</p>';
				echo '<a href="index.php?r=album/delete&id='.$image->id.'" class="btn btn-default btn-xs" role="button">删除</a>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}		
			echo '</div>';
		}
	?>
    
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
<!-- 图片显示与上传结束     -->
	
    

    <?php //echo $form->field($model, 'thumbsup')->textInput() ?>

    <?php //echo $form->field($model, 'thumbsdown')->textInput() ?>     		

    <?php //echo $form->field($model, 'comment_count')->textInput() ?>

    <?php //echo $form->field($model, 'created_date')->textInput() ?>

    <?php //echo $form->field($model, 'updated_date')->textInput() ?>

    <?php //echo $form->field($model, 'interested_count')->textInput() ?>

    <?php //echo $form->field($model, 'recomended_count')->textInput() ?>

    <?php //echo $form->field($model, 'view_count')->textInput() ?>
    <div class="panel panel-default">
  		<div class="panel-heading">
   			<h3 class="panel-title">标签</h3>
  		</div>
  		<div class="panel-body">
  			<?php 
  				$tagMaps=$model->getTagMaps();
  				foreach ($tagMaps as $tagMap)
  			:?>
  				<span class="label label-success"><?= $tagMap->tag->name?></span>
  			<?php endforeach;?>			
<!-- 			<span class="label label-primary">Primary</span> -->
<!-- 			<span class="label label-success">Success</span> -->
<!-- 			<span class="label label-info">Info</span> -->
<!-- 			<span class="label label-warning">Warning</span> -->
<!-- 			<span class="label label-danger">Danger</span> -->
  			<?= $form->field($model, 'tag_string')->label('')->textInput(['placeholder'=>'增加新标签，以空格为分割可以同时增加多个标签']) ?>
  		</div>
	</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    


</div>
