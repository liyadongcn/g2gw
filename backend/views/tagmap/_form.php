<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Tagmap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tagmap-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tagid')->textInput() ?>

    <?= $form->field($model, 'model_type')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'model_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
