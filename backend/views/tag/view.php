<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Tag;
use backend\models\BrandSearch;

/* @var $this yii\web\View */
/* @var $model common\models\Tag */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-view">

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
            'name',
            'count',
        	'model_type',
        ],
    ]) ?>

</div>

<!-- 相同标签的数据列表开始 -->
<div>
<?php $dataProvider=$model->getModels();?>
<?php switch ($model->model_type):?>
<?php case Tag::MODEL_TYPE_BRAND:?>
	<?php $searchModel=new BrandSearch();?>
	<?php echo $this->render('@app/views/brand/index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);?>
	<?php break;?>
<?php case Tag::MODEL_TYPE_GOODS: ?>
	<?php echo $this->render('@app/views/goods/index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);?>
	<?php break;?>
<?php case Tag::MODEL_TYPE_POSTS: ?>
	<?php echo $this->render('@app/views/posts/index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);?>
	<?php break;?>
<?php default:?>
<?php endswitch;?>
</div>
<!-- 相同标签的数据列表结束 -->