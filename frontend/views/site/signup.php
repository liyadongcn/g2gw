<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */


$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;

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
                    <div class="form-group">
                        <?= Html::submitButton('Signup', ['class' => 'btn btn-primary  btn-lg btn-block', 'name' => 'signup-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
	    
	

