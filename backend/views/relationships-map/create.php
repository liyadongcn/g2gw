<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RelationshipsMap */

$this->title = 'Create Relationships Map';
$this->params['breadcrumbs'][] = ['label' => 'Relationships Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relationships-map-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
