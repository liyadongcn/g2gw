<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pricehistory */

$this->title = 'Update Pricehistory: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pricehistories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pricehistory-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
