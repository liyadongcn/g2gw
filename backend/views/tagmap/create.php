<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Tagmap */

$this->title = 'Create Tagmap';
$this->params['breadcrumbs'][] = ['label' => 'Tagmaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tagmap-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
