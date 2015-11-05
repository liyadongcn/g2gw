<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="login-box">
<div class="login-logo">
<a href="/index.php"><b>G2GW</b>admin</a>
</div>
<!-- /.login-logo -->
<div class="login-box-body">
<p class="login-box-msg">登录后台进行管理操作</p>

<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username',['options'=>[
                			'tag'=>'div',
                			'class'=>'form-group field-loginform-username has-feedback required'
                		],
                		'template'=>'{input}<span class="glyphicon glyphicon-user form-control-feedback"></span>{error}{hint}',
                ])->textinput(['placeholder'=>'用户名']) ?>
                <?= $form->field($model, 'password',['options'=>[
                			'tag'=>'div',
                			'class'=>'form-group field-loginform-username has-feedback required'
                		],
                		'template'=>'{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>{error}{hint}',
                ])->passwordInput(['placeholder'=>'密码']) ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div class="form-group">
                    <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
                </div>
<?php ActiveForm::end(); ?>

      <a href="#">忘记密码</a><br>
      <a href="register.html" class="text-center">注册</a>

   </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<?php $script = <<< JS
 $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
JS;
	$this->registerJs($script);
?>
