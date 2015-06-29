<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\CategoryMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-map-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'model_type')->dropDownList(
                            $model->getDropDownListData('model_type'),
                                                [
                                                        'prompt' => '请选择分类数据类型......',
                                                        'onchange' => '
                                                            $.post( "index.php?r=category/list&model_type="+$(this).val(), function( data ) {
                                                                $( "select#categorymap-category_id" ).html( data );
                                                            });
                                                        '
                                                    ]
        
        ) ?>

         <?= $form->field($model, 'category_id')->dropDownList(
                            $model->getDropDownListData('category_id'),
                                                ['prompt' => '请选择分类']
        
        ) ?>

    <?php 
    	//$form->field($model, 'goods_id')->textInput();
        echo $form->field($model, 'model_id')->widget(Select2::classname(), [
   		'data' => $model->getDropDownListData('model_id'),
   		'options' => ['placeholder' => '请选择归类数据 ...'],
   		'pluginOptions' => [
   				'allowClear' => true
   		],
   ]); 
        ?>
	

    <?php //echo $form->field($model, 'category_id')->textInput() ?>
    
     
   
    
   	<?php //echo $form->field($model, 'category_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
