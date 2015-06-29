<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RelationshipsMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="relationships-map-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'relationship_id')->textInput() ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'model_type')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'model_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
