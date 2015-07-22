<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\data\Sort;

/* @var $this yii\web\View */
$this->title = 'Solr Response';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>This is response from the solr server:</p>
    
<!-- 排序开始 -->
	<?php $sort=$dataProvider->sort;?>
	<?php echo $sort->link('id');?>
<!-- 排序结束     -->
	
  
<?php $models=$dataProvider->models;?>
<?php if($models) :?>
<ul class="list-group">
    <li class="list-group-item">
    <?php foreach ($models as $model):?>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media">
                    <div class="media-left media-middle">
                        
                    </div>
                    <div class="media-body">
                        <a href="<?= Html::encode($model->id)?>">
                            <h1 class="media-heading"><?php echo html::encode($model->id)?></h1>
                        </a>
                        <p>
                            <?php //echo html::encode($model->tstamp)?>
                             
                        </p>
                        
                    </div>
                    <p class="text-right">
                            <?php //if ($model->url) :?>
                                <a class="btn btn-success" href="<?php //echo html::encode($model->url);?>" role="button">去购买</a>
                            <?php //endif;?>
                    </p>
                </div>
            </div>
            <div class="panel-footer">
                
            </div>
        </div>
  <?php endforeach;?>
  </li>
</ul>
<?php else:?>
    <div class="alert alert-danger" role="alert">抱歉！啥也没找到！</div>
<?php endif;?>
    
<!-- 分页开始 -->
    <?php 
		echo LinkPager::widget([
			'pagination' => $dataProvider->getPagination(),
		]);
	?>
<!-- 分页结束 -->
	
</div>