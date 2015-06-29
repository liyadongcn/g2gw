<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CategoryMap */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Category Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-map-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['@web/category-map/update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['@web/category-map/delete', 'id' => $model->id], [
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
            'model_id',
           'model_type',
            'category_id',
        ],
    ]) ?>

</div>
