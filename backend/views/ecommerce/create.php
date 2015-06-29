<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Ecommerce */

$this->title = 'Create Ecommerce';
$this->params['breadcrumbs'][] = ['label' => 'Ecommerces', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ecommerce-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
