<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Pricehistory */

$this->title = 'Create Pricehistory';
$this->params['breadcrumbs'][] = ['label' => 'Pricehistories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pricehistory-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
