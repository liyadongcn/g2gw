<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = '修改个人信息 ' ;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="page-header">
		<h1><?= Html::encode($this->title) ?></h1>
		</div>
	</div>
</div>
<div class="row text-center">
	<div class="col-md-4 col-md-offset-4 ">
		<div class="img-thumbnail " id="crop-avatar">
			<div class="avatar-view " title="点击进行修改">
					<img  src=<?= html::encode($model->face); ?> alt="Avatar">
			</div>
			<!--  用户头像修改Modal开始 -->
			<!-- Cropping modal -->
			<div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
			  <div class="modal-dialog modal-lg">
			    <div class="modal-content">
			      <form class="avatar-form" action=<?= Url::to(['user/change-avatar','id'=>$model->id])?> enctype="multipart/form-data" method="post">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			          <h4 class="modal-title" id="avatar-modal-label">头像修改</h4>
			        </div>
			        <div class="modal-body">
			          <div class="avatar-body">

			            <!-- Upload image and data -->
			            <div class="avatar-upload">
			              <input type="hidden" class="avatar-src" name="avatar_src">
			              <input type="hidden" class="avatar-data" name="avatar_data">
			              <label for="avatarInput">选择头像图片</label>
			              <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
			            </div>

			            <!-- Crop and preview -->
			            <div class="row">
			              <div class="col-md-9">
			                <div class="avatar-wrapper"></div>
			              </div>
			              <div class="col-md-3">
			                <div class="avatar-preview preview-lg"></div>
			                <div class="avatar-preview preview-md"></div>
			                <div class="avatar-preview preview-sm"></div>
			              </div>
			            </div>

			            <div class="row avatar-btns">
			              <div class="col-md-9">
			                <div class="btn-group">
			                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">左转</button>
			                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-15度</button>
			                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-30度</button>
			                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-45度</button>
			                </div>
			                <div class="btn-group">
			                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees">右转</button>
			                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="15">15度</button>
			                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="30">30度</button>
			                  <button type="button" class="btn btn-primary" data-method="rotate" data-option="45">45度</button>
			                </div>
			              </div>
			              <div class="col-md-3">
			                <button type="submit" class="btn btn-primary btn-block avatar-save">确定</button>
			              </div>
			            </div>
			          </div>
			        </div>
			        <!-- <div class="modal-footer">
			          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        </div> -->
			      </form>
			    </div>
			  </div>
			</div><!-- /.modal -->    
			<!--  用户头像修改Modal结束 -->
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
	    <?php $form = ActiveForm::begin(['id' => 'form-update','options' => ['enctype' => 'multipart/form-data']]); ?>
	        <?= $form->field($model, 'nickname') ?>
	        <?= $form->field($model, 'email') ?> 	       
	        <?= $form->field($model, 'cellphone') ?>	         
	        <div class="form-group">
	            <?= Html::submitButton('确定', ['class' => 'btn btn-primary  btn-lg btn-block', 'name' => 'update-button']) ?>
	        </div>
	    <?php ActiveForm::end(); ?>
	</div>
</div>

 </div>
 <!-- Loading state -->
    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
