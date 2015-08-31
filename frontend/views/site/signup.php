<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */


$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;

?>

	  
	   <div class="site-signup">
      	
        

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
             <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
             <p>请填写注册信息 注册后您可以推荐官网精品、活动及购物经验并能收藏您的喜好:</p>
                <?php $form = ActiveForm::begin(['id' => 'form-signup','options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $form->field($model, 'username') ?>
                    <?= $form->field($model, 'email') ?>                
                    <?= $form->field($model, 'password_repeat')->passwordInput() ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                     <?php //echo $form->field($model, 'cellphone') ?>
                     <?php //echo $form->field($model, 'file')->fileInput() ?>
                    <div class="form-group">
                        <?= Html::submitButton('免费注册', ['class' => 'btn btn-primary  btn-lg btn-block', 'name' => 'signup-button']) ?>
                    </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
	    
	

