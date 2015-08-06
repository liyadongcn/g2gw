<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
         	<h1><?= Html::encode($this->title) ?></h1>
    		<p>请输入登录信息</p>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div style="color:#999;margin:1em 0">
                    忘记密码 <?= Html::a('重置密码', ['site/request-password-reset']) ?>.
                </div>
                <?= AuthChoice::widget([
				     'baseAuthUrl' => ['site/auth'],
				     'popupMode' => false,
				]) ?>
                <div class="form-group">
                    <?= Html::submitButton('登录', ['class' => 'btn btn-primary btn-block btn-lg', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
