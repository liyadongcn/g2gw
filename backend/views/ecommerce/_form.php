<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Ecommerce */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ecommerce-form">

    <?php $form = ActiveForm::begin(); ?>

     <?php echo $form->field($model, 'brand_id')->dropDownList(
    												$model->getDropDownListData('brand_id'),
    		                                        ['prompt' => '请选择商品品牌']
    		
    		) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => 255]) ?>
    
     <?= $form->field($model, "link_promotion")->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 30]) ?>

     <?php echo $form->field($model, 'is_domestic')->dropDownList(
    												$model->getDropDownListData('is_domestic'),
    		                                        ['prompt' => '国内网还是国际网']
    		
    		) ?>

    <?php echo $form->field($model, 'accept_order')->dropDownList(
    												$model->getDropDownListData('accept_order'),
    		                                        ['prompt' => '能否在线购买']
    		
    		) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
