<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use bupy7\cropbox\Cropbox;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* 使用bupy7\cropbox\Cropbox widget修改用户头像 ，手机上不能使用*/
?>

    <div class="site-signup">
      	
        <h2>修改头像</h2>
		<img class="media-object img-thumbnail" src=<?= html::encode($model->face); ?> alt=<?= html::encode($model->username)?>>
        <div class="row">
            <div class="col-md-12">
                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                   
                     <?= $form->field($model, 'file')->widget(Cropbox::className(), [
					    'attributeCropInfo' => 'crop_info',
                     	//'previewImagesUrl' => [$model->face,],
                     	'pluginOptions' => [
                     			/* 'optionsCropbox' => [
                     					'boxWidth' => 200,
                     					'boxHeight' => 200,
                     					'cropSettings' => [
                     							[
                     								'width' => 100,
                     								'height' => 100,
                     							],
                     					],
                     			], */
                     			'variants' => [
                     					[
                     							'width' => 100,
                     							'height' => 100,
                     					],
                     			],
                     			
                     			
                     	],                     	
					])->label('点击浏览按钮选择图片'); ?>
                     
                    <div class="form-group">
                        <?= Html::submitButton('修改', ['class' => 'btn btn-primary  btn-lg btn-block', 'name' => 'signup-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

