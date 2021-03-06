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
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model common\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php 
   // Usage with ActiveForm and model
    echo $form->field($model, 'brand_id')->widget(Select2::classname(), [
      'data' => $model->getDropDownListData(MODEL_TYPE_BRAND),
      'options' => ['placeholder' => '请选择品牌 ...'],
      'pluginOptions' => [
          'allowClear' => true
      ],
   ]); 
   
   ?> 

    <?= $form->field($model, 'post_title')->textInput(['maxlength' => 100]) ?>

    <?php //echo  $form->field($model, 'post_content')->textarea(['rows' => 6]) ?>
    
    <?php echo $form->field($model, 'post_content')->widget(Widget::className(), [
	    'settings' => [
	        'lang' => 'zh_cn',
	        'minHeight' => 200,
	    	'imageUpload' => Url::to(['/posts/image-upload']),
	        'plugins' => [
	            'clips',
	            'fullscreen'
	        ]
	    ]
	]);?>

    <?php 
//     echo $form->field($model, 'brand_id')->dropDownList(
//     		$model->getDropDownListData(MODEL_TYPE_BRAND),
//     		[
//     				'prompt'=>'选择涉及的品牌......'
    				
//    			 ]) 
    ?>
    
  
   			 
 <!-- 文章分类开始 -->
	 <div class="panel panel-default">
  		<div class="panel-heading">
   			<h3 class="panel-title">分类</h3>
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

    <?php echo $form->field($model, 'url')->textInput(['maxlength' => 255]) ?>

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
  	<!--      <?php
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
            echo '<a href="index.php?r=album/delete&id='.$image->id.'" class="btn btn-default btn-xs" role="button">删除</a></p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }    
          echo '</div>';
        }
      ?> -->
    
    <?php 
    // Display an initial preview of files with caption
    // (useful in UPDATE scenarios). Set overwrite `initialPreview`
    // to `false` to append uploaded images to the initial preview.
    // Usage with ActiveForm and model
//      echo $form->field($model, 'file[]')->widget(FileInput::classname(), [
//      		'options'=>[
//      				'multiple'=>true
//      		],
//      		'pluginOptions' => [
//     			//'initialPreview'=>empty($initialPreview)?array():$initialPreview,
//     			/* [
//     				Html::img("/images/moon.jpg", ['class'=>'file-preview-image', 'alt'=>'The Moon', 'title'=>'The Moon']),
//     		    	Html::img("/images/earth.jpg",  ['class'=>'file-preview-image', 'alt'=>'The Earth', 'title'=>'The Earth']),
//     		    	], */
//      		 	'initialCaption'=>"选择图片",
//      		  'overwriteInitial'=>false,
//      			'previewFileType' => 'image',
//      			'showCaption' => false,
//      			'showRemove' => true,
//      			'showUpload' => false,
// //      			'browseClass' => 'btn btn-primary btn-block',
// //      			'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
// //      			'browseLabel' =>  'Select Photo',
//      			//'initialPreviewShowDelete'=>true,
//      			//'initialPreviewConfig'=>empty($initialPreviewConfigs)?array():$initialPreviewConfigs,
//      		]
//      	]);
    
      // Multiple file/image selection with image only preview
      // Note for multiple file upload, the attribute name must be appended with 
      // `[]` for PHP to be able to read an array of files
      echo $form->field($model, 'file[]')->widget(FileInput::classname(), [
          'options' => ['multiple' => true, 'accept' => 'image/*'],
          'pluginOptions' => ['previewFileType' => 'image','showCaption' => false]
      ]);
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
  					<span class="label label-success"><?= $tagMap->tag->name?></span>
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
        <?= Html::submitButton($model->isNewRecord ? '提交' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $script = <<< JS
	//给发表的活动标题自动增加品牌名称
    $("#posts-brand_id").change(function(){
    	var brandName=$("#posts-brand_id").find("option:selected").text();
        //alert($("#posts-brand_id").find("option:selected").text());
        if($("#posts-brand_id").val()!="")
        {
            var title= $("#posts-post_title").val();
            $("#posts-post_title").val(brandName+title);            
        }        
    });
    $("#posts-post_title").click(function(){
        var brandName=$("#posts-brand_id").find("option:selected").text();
        //alert($("#posts-brand_id").find("option:selected").text());
        if($("#posts-brand_id").val()!="" && $("#posts-post_title").val()=="")
        {
            $("#posts-post_title").val(brandName);            
        }        
    });
    //给发表的活动按照标题自动增加内容
    $("#posts-post_content").click(function(){
        var title=$("#posts-post_title").val();
        //alert($("#posts-brand_id").find("option:selected").text());
        if($("#posts-post_content").val()=="")
        {
            $("#posts-post_content").val(title);
        }        
    });
JS;
   $this->registerJs($script);
?>
