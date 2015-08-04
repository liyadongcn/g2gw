<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Brand */

$this->title = '推荐品牌';
$this->params['breadcrumbs'][] = ['label' => 'Brands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-create">
	<div class="page-header">
    <h3><?= Html::encode($this->title) ?><small>您的每一次推荐都是对我们的激励</small></h3>
	</div>
    <?= $this->render('_form', [
        'model' => $model,
    	'modelEcommerces' => $modelEcommerces,
    ]) ?>

</div>
