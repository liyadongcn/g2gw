<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = '推荐官网精品';
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-create">

	<div class="page-header">

    <h3><?= Html::encode($this->title) ?><small>您的每一次推荐都是对我们的激励</small></h3>

	</div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
