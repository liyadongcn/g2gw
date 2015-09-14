<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
//use common\models\Brand;
//use common\models\Album;
use common\models\Category;
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
   		'data' => $model->getDropDownListData(MODEL_TYPE_BRAND),
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
<!-- 图片显示与上传结束     -->
	
    

    <?php echo $form->field($model, 'thumbsup')->textInput() ?>

    <?php echo $form->field($model, 'thumbsdown')->textInput() ?>     		

    <?php //echo $form->field($model, 'comment_count')->textInput() ?>

    <?php //echo $form->field($model, 'created_date')->textInput() ?>

    <?php //echo $form->field($model, 'updated_date')->textInput() ?>

    <?php //echo $form->field($model, 'interested_count')->textInput() ?>

    <?php //echo $form->field($model, 'recomended_count')->textInput() ?>

    <?php echo $form->field($model, 'view_count')->textInput() ?>
<!-- 标签开始 -->
    <div class="panel panel-default">
  		<div class="panel-heading">
   			<h3 class="panel-title">标签</h3>
  		</div>
  		<div class="panel-body">
  			<?php 
  				$tagMaps=$model->getTagMaps()->all();
  				foreach ($tagMaps as $tagMap)
  			:?>
  				<span class="label label-success"><?= $tagMap->tag->name?>
  				<a href=<?= url::to(['tagmap/delete','id'=>$tagMap->id])?>>
  					<span class="glyphicon glyphicon-remove"><span>
  				</a>  
  				</span>&nbsp;
  			<?php endforeach;?>			
<!-- 			<span class="label label-primary">Primary</span> -->
<!-- 			<span class="label label-success">Success</span> -->
<!-- 			<span class="label label-info">Info</span> -->
<!-- 			<span class="label label-warning">Warning</span> -->
<!-- 			<span class="label label-danger">Danger</span> -->
  			<?= $form->field($model, 'tag_string')->label('')->textInput(['placeholder'=>'增加新标签，以空格为分割可以同时增加多个标签']) ?>
  		</div>
	</div>
<!-- 标签结束 -->
	
<!-- 品牌分类开始 -->
	 <div class="panel panel-default">
  		<div class="panel-heading">
   			<h3 class="panel-title">分类</h3>
  		</div>
  		<div class="panel-body">
		<?php $categories =ArrayHelper::map(Category::findAll(['model_type'=>$model->modelType()]),'id','name')?>
   		<?= $form->field($model, 'categories')->checkboxlist($categories) ?>
      	</div>
	</div>
<!-- 品牌分类结束 -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    


</div>
