<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '修改登录密码 ' ;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update-password">
   
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="page-header">
		<h1><?= Html::encode($this->title) ?></h1>
		</div>
	    <?php $form = ActiveForm::begin(['id' => 'form-update','options' => ['enctype' => 'multipart/form-data']]); ?>
	    	<?= $form->field($model, 'original_password')->passwordInput() ?>
	        <?= $form->field($model, 'password')->passwordInput()->label('新密码') ?>
	        <?= $form->field($model, 'password_repeat')->passwordInput()->label('重复新密码') ?> 		                
	        <div class="form-group">
	            <?= Html::submitButton('确定', ['class' => 'btn btn-primary  btn-lg btn-block', 'name' => 'update-button']) ?>
	        </div>
	    <?php ActiveForm::end(); ?>
	</div>
</div>

</div>
 