<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Brand;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\EcommerceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ecommerce-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // echo $form->field($model, 'id') ?>

     <?php echo $form->field($model, 'brand_id')->dropDownList(
    												ArrayHelper::map(Brand::find()->all(),'id','en_name'),
    		                                        ['prompt' => '请选择检索品牌']
    		
    		) ?>

    <?php // echo $form->field($model, 'website') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'is_domestic') ?>

    <?php // echo $form->field($model, 'accept_order') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
