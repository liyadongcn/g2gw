<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RelationshipsMap */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Relationships Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="relationships-map-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'relationship_id',
            'userid',
            'model_type',
            'model_id',
        ],
    ]) ?>

</div>
