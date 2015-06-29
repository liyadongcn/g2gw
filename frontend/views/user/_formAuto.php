<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'email') ?>                
    <?php //echo  $form->field($model, 'password_repeat')->label('password')->passwordInput() ?>
    <?php //echo  $form->field($model, 'password')->label('repeat_password')->passwordInput() ?>
    <?= $form->field($model, 'cellphone') ?>
    <?php //echo $form->field($model, 'file')->fileInput() ?>
    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
