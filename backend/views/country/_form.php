<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Country */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="country-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 3]) ?>

    <?= $form->field($model, 'en_name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'population')->textInput() ?>

    <?= $form->field($model, 'cn_name')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'flag')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
