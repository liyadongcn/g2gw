<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Posts;
use common\models\Category;
use common\models\Links;
use kartik\widgets\datepicker;
use kartik\widgets\DateTimePicker;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use vova07\imperavi\Widget;
//use kucha\ueditor\UEditor;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form','options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'post_title')->textInput(['maxlength' => 100]) ?>

    <?php //echo $form->field($model, 'post_content')->textarea(['rows' => 6]) ?>
    
    <?php echo $form->field($model,'post_content')->widget('kucha\ueditor\UEditor',[]);?>
    
    <?php /* echo $form->field($model, 'post_content')->widget(Widget::className(), [
	    'settings' => [
	        'lang' => 'zh_cn',
	        'minHeight' => 200,
	    	'imageUpload' => Url::to(['/posts/image-upload']),
	        'plugins' => [
	            'clips',
	            'fullscreen'
	        ]
	    ]
	]); */?>
    

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
   			<h3 class="panel-title">活动及文章分类</h3>
  		</div>
  		<div class="panel-body">
		<?php $categories =ArrayHelper::map(Category::findAll(['model_type'=>$model->modelType()]),'id','name')?>
   		<?= $form->field($model, 'categories')->checkboxlist($categories)->label(false) ?>
      	</div>
	</div>
<!-- 文章分类结束 -->

    <?php echo $form->field($model, 'post_status')->dropDownList(
    		$model->getDropDownListData(MODEL_TYPE_POSTS_STATUS),
    		[
    				'prompt'=>'状态'
    				
   			 ]) ?>

    <?php //echo $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

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
            <span class="glyphicon glyphicon-remove"></span>
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

	<!--  网络连接开始 -->
 

             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 0, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelLinks[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'link_name',
                	'link_url',
                	'link_promotion',
                    'link_description',
                ],
            ]); ?>

        
        <div class="panel panel-default">
        <div class="panel-heading">
            <h4>
                <i class="glyphicon glyphicon-link"></i> 活动及文章网络链接
                <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</button>
            </h4>
        </div>
        <div class="panel-body">
            <div class="container-items"><!-- widgetBody -->
            <?php foreach ($modelLinks as $i => $modelLink): ?>
                <div class="item panel panel-default"><!-- widgetItem -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">链接</h3>
                        <div class="pull-right">
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelLink->isNewRecord) {
                                echo Html::activeHiddenInput($modelLink, "[{$i}]id");
                            }
                        ?>
                       
                        <?= $form->field($modelLink, "[{$i}]link_name")->textInput(['maxlength' => 30]) ?>

                        <?= $form->field($modelLink, "[{$i}]link_url")->textInput(['maxlength' => 500]) ?>
                        
                        <?= $form->field($modelLink, "[{$i}]link_promotion")->textInput(['maxlength' => 500]) ?>
                        
                        <?= $form->field($modelLink, "[{$i}]link_description") ->textarea(['rows' => 6]) ?>
        
                              </div>
                          </div>
                      <?php endforeach; ?>
                      </div>
                  </div>
              </div><!-- .panel -->
        
            <?php DynamicFormWidget::end(); ?>
    
<!--  网络连接结束 -->
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
