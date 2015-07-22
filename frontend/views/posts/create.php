<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Posts */

$this->title = '推荐促销活动 购物经验';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
