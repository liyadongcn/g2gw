<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'telphone')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'fax')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'contact')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'cell')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'qq')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'vchat')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 50]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
