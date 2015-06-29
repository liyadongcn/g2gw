<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CategoryMap */

$this->title = 'Create Category Map';
$this->params['breadcrumbs'][] = ['label' => 'Category Maps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-map-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
