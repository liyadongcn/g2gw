<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="site-signup">
      	
        <p>Please fill out the following fields to signup:</p>

        <div class="row">
            <div class="col-md-12">
                <?php $form = ActiveForm::begin(['id' => 'form-signup','options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $form->field($model, 'username') ?>
                    <?= $form->field($model, 'email') ?>                
                    <?= $form->field($model, 'password_repeat')->label('password')->passwordInput() ?>
                    <?= $form->field($model, 'password')->label('repeat_password')->passwordInput() ?>
                     <?= $form->field($model, 'cellphone') ?>
                     <?= $form->field($model, 'file')->fileInput() ?>
                     <?php $modelAuthItems =ArrayHelper::map($modelAuthItems,'name','description')?>
                     <?= $form->field($model, 'permissions')->checkboxlist($modelAuthItems) ?>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Signup' : 'Update', ['class' => 'btn btn-primary  btn-lg btn-block', 'name' => 'signup-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

