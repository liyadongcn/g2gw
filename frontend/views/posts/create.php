<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Posts */

$this->title = '推荐促销活动 购物经验';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-create">
	<div class="page-header">
    <h3><?= Html::encode($this->title) ?><small>您的每一次推荐都是对我们的激励</small></h3>
	</div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
