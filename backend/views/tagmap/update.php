<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tagmap */

$this->title = 'Update Tagmap: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tagmaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tagmap-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
