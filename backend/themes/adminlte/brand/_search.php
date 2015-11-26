<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BrandSearch */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
        'action' => ['search-by-key-words'],
        'method' => 'get',
    ]); ?>
    <div class="input-group">
    <?php  echo $form->field($model, 'keyWords')->label(false); ?>
    
    <div class="input-group-btn">
    <?= Html::submitButton('搜索', ['class' => 'btn btn-flat']) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>
    
    <br>

</div>
