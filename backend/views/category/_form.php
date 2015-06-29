<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Category;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'model_type')->dropDownList(
    												$model->getDropDownListData('model_type'),
    		                                        [
                                                        'prompt' => '请选择分类数据类型......',
                                                        'onchange' => '
                                                            $.post( "index.php?r=category/list&model_type="+$(this).val(), function( data ) {
                                                                $( "select#category-parent_id" ).html( data );
                                                            });
                                                        '
                                                    ]
    		
    		) ?>

    <?= $form->field($model, 'parent_id')->dropDownList(
    												ArrayHelper::map(Category::orgnizedCateName(0,$model->model_type),'id','name'),
    		                                        ['prompt' => '请选择父分类，默认不选为顶级分类......']
    		
    		) ?>
    		
    <?php //print_r(Category::orgnizedCateName()) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 30]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
