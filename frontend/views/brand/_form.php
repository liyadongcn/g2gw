<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Country;
use common\models\Company;
use common\models\Ecommerce;
use kartik\widgets\FileInput;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\Category;


/* @var $this yii\web\View */
/* @var $model common\models\Brand */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="brand-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form','options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'en_name')->textInput(['maxlength' => 30]) ?>

     <?= $form->field($model, 'cn_name')->textInput(['maxlength' => 30]) ?>

    <?php //echo $form->field($model, 'country_code')->textInput(['maxlength' => 3]) ?>
    
   <?= $form->field($model, 'introduction')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'baidubaike')->textInput(['maxlength' => 255]) ?>

    <?php //echo $form->field($model, 'logo')->textInput(['maxlength' => 255]) ?>
    <?php //echo $form->field($model, 'file')->fileInput() ?>
    
    <!-- 图片显示与上传开始 -->
     <div class="panel panel-default">
  		<div class="panel-heading">
   			<h3 class="panel-title">品牌logo</h3>
  		</div>
  		<div class="panel-body">
  			 <?php
		if(!empty($model->logo)){
			echo '<div class="row">';			
				echo '<div class="col-sm-6 col-md-3 col-lg-2"">';
				echo '<div class="thumbnail">';
				echo '<img src="'.$model->logo.'" class="img-responsive img-thumbnail" alt="Responsive image" width="200">';
				echo '<div class="caption">';
				//echo '<h3>Thumbnail label</h3>';
				//echo '<p>...</p>';
				//echo '<a href="index.php?r=album/delete&id='.$image->id.'" class="btn btn-default btn-xs" role="button">删除</a></p>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			echo '</div>';
		}
	?>
    
    <?php 
    // Display an initial preview of files with caption
    // (useful in UPDATE scenarios). Set overwrite `initialPreview`
    // to `false` to append uploaded images to the initial preview.
    // Usage with ActiveForm and model
     echo $form->field($model, 'file')->widget(FileInput::classname(), [
     		'options'=>[
     				'multiple'=>false
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
     	])->label('上传品牌logo');
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

    <?= $form->field($model, 'country_code')->dropDownList(
                            $model->getDropDownListData(MODEL_TYPE_COUNTRY),
                                                ['prompt' => '选择国家......']
        
        ); ?>

    

    <?php //echo  $form->field($model, 'thumbsup')->textInput() ?>

    <?php //echo $form->field($model, 'thumbsdown')->textInput() ?>

    <?php //echo $form->field($model, 'company_id')->textInput() ?>
     
    <?php //echo  $form->field($model, 'company_id')->dropDownList(	$model->getDropDownListData('company_id'),['prompt' => '选择公司......']); ?>
    

    <?php //echo = $form->field($model, 'comment_count')->textInput() ?>

    <?php //echo  $form->field($model, 'view_count')->textInput() ?>

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
	
<!--  电商网站开始 -->
 

             <?php DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 0, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $modelEcommerces[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'website',
                    'name',
                    'is_domestic',
                    'accept_order',
                ],
            ]); ?>

        
        <div class="panel panel-default">
        <div class="panel-heading">
            <h4>
                <i class="glyphicon glyphicon-shopping-cart"></i> 电商
                <button type="button" class="add-item btn btn-success btn-sm pull-right"><i class="glyphicon glyphicon-plus"></i> Add</button>
            </h4>
        </div>
        <div class="panel-body">
            <div class="container-items"><!-- widgetBody -->
            <?php foreach ($modelEcommerces as $i => $modelEcommerce): ?>
                <div class="item panel panel-default"><!-- widgetItem -->
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">电商信息</h3>
                        <div class="pull-right">
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                            // necessary for update action.
                            if (! $modelEcommerce->isNewRecord) {
                                echo Html::activeHiddenInput($modelEcommerce, "[{$i}]id");
                            }
                        ?>
                       
                        <?= $form->field($modelEcommerce, "[{$i}]website")->textInput(['maxlength' => 255]) ?>

                        <?= $form->field($modelEcommerce, "[{$i}]name")->textInput(['maxlength' => 30]) ?>

                        <?= $form->field($modelEcommerce, "[{$i}]is_domestic")->dropDownList(
                                                Ecommerce::getDropDownListData('is_domestic'),
                                                ['prompt' => '国内网还是国际网']
        
                        ) ?>

                        <?= $form->field($modelEcommerce, "[{$i}]accept_order")->dropDownList(
                                                Ecommerce::getDropDownListData('accept_order'),
                                                ['prompt' => '能否在线购买']
          
                        ) ?>
                              </div>
                          </div>
                      <?php endforeach; ?>
                      </div>
                  </div>
              </div><!-- .panel -->
        
            <?php DynamicFormWidget::end(); ?>
    
<!--  电商网站结束 -->
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '提交' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    


</div>
