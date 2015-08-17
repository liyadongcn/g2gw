<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model */


$this->title = yii::$app->name;
?>
<div class="solr-search">

    <h3><?= Html::encode('官网搜') ?></h3>

     <?php $form = ActiveForm::begin([
     		'method'=>'get',
     		//'type' => ActiveForm::TYPE_INLINE,
     		'fullSpan' => 12,
     		'formConfig' => ['showErrors' => true],     		
     ]); ?>

    <?= $form->field($model, 'keyWords', [
	    'addon' => [
	        'append' => [
	            'content' => Html::submitButton('搜索一下', ['class'=>'btn btn-primary']), 
	            'asButton' => true
	        ]
	    ]
	])->textInput()->label(false) ?>

    <?php ActiveForm::end(); ?>
	<p>
        	所有的搜索结果将来自商家的官网信息.
    </p>
    <p>
        	请仔细填写关键词，以便系统为您找到最合适的商品.
    </p>
    
</div>