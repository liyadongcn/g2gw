<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use common\models\Category;
use backend\models\BrandSearch;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Brands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-index">

	<h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModelIndex]); ?>

    <p>
        <?= Html::a('Create Brand', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
<!-- 列表显示开始 -->
 <?php 
    	echo  GridView::widget([
        'dataProvider' => $dataProviderIndex,
        //'filterModel' => false,//$searchModel,    			
    	'options' => ['class' => 'grid-view table-responsive'],
        'tableOptions' => ['class' => ' table table-hover'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'en_name',
            'country.cn_name',
            //'logo',
            'cn_name',
            //'introduction:ntext',
            //'baidubaike',
            'thumbsup',
            'thumbsdown',
            //'company.name',
            'comment_count',
            'view_count',

            ['class' => 'yii\grid\ActionColumn'],
        ] ] );
    	?>

</div>
<!-- 列表显示结束 -->

<!-- 带logo显示开始 -->
<?php $models=$dataProviderIndex->models;?>
<?php if($models) :?>
<ul class="list-group">
	<li class="list-group-item">
  	<?php foreach ($models as $model):?>
  		<div class="panel panel-default">
			<div class="panel-body">
				<div class="media">
					<div class="media-left media-middle">
						<a href="<?= Url::to(['view','id'=>$model->id])?>"> <img
							class=" media-object img-rounded" src="<?= html::encode($model->logo)?>"
							alt="..." width="200">
						</a>
					</div>
					<div class="media-body">
						<h1 class="media-heading"><?= html::encode($model->en_name)?></h1>
						<p>
							<?= html::encode($model->introduction)?>
						</p>
						<p class="text-right">
							<?php $ecommerces=$model->ecommerces;?>
							<?php if ($ecommerces) :?>
							<?php foreach ($ecommerces as $ecommerce) :?>
								<a class="btn btn-success" href="<?= html::encode($ecommerce->website);?>" role="button"><?= html::encode($ecommerce->name);?></a>
							<?php endforeach;?>
							<?php endif;?>
						</p>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				<div>
				<div class='text-left'>
  					<?php $tagMaps=$model->getTagMaps()->all();?>
  					<?php if($tagMaps):?>
  					<?php foreach ($tagMaps as $tagMap):?>  			
  						<span class="label label-success"><?= $tagMap->tag->name?></span>
  					<?php endforeach;?>	
  					<?php endif;?>		
<!-- 			<span class="label label-primary">Primary</span> -->
					<!-- 			<span class="label label-success">Success</span> -->
					<!-- 			<span class="label label-info">Info</span> -->
					<!-- 			<span class="label label-warning">Warning</span> -->
					<!-- 			<span class="label label-danger">Danger</span> -->
				</div>
				<p class='text-right'>
					<a href="<?= Url::to(['thumbsup','id' => $model->id])?>"> <span
						class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
					</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsup) ?></span>
					&nbsp;| <a href="<?= Url::to(['thumbsdown','id' => $model->id])?>">
						<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
					</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsdown) ?></span>
					&nbsp;| <span class="glyphicon glyphicon-comment"
						aria-hidden="true"></span> <span class="badge" aria-hidden="true"><?= Html::encode($model->comment_count) ?></span>
					&nbsp;| <span class="glyphicon glyphicon-eye-open"></span> <span
						class="badge"><?= Html::encode($model->view_count) ?></span>
				</p>
				</div>
			</div>
		</div>
  <?php endforeach;?>
  </li>
</ul>
<?php endif;?>

<?php 
// 显示分页
echo LinkPager::widget([
		'pagination' => $dataProviderIndex->getPagination(),
]);
?>
<!-- 带logo显示结束 -->
    
<!-- 分类别显示开始 -->
<?php $categories=Category::getCategories(0,MODEL_TYPE_BRAND)?>
<?php if($categories):?>
	<?php foreach ($categories as $category):?>
		  <!-- Category LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">
                  <?= html::encode($category->name)?>
                  </h3>                                             
                  <div class="box-tools pull-right">
		                  <?php $subCategories=$category->getCategories($category->id,MODEL_TYPE_BRAND)?>
		                  <?php foreach ($subCategories as $subCategory):?>
		                  &nbsp;
		                  	<span class="label label-default">
		                  	<a href="<?= url::to(['brand/search-by-category','category_id'=>$subCategory->id])?>" class="uppercase"><?= $subCategory->name;?></a>
		                  	</span> 
		                  <?php endforeach;?>
<!--                     <span class="label label-danger">8 New Members</span> -->
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                <?php $searchModel=new BrandSearch();?>                
                <?php $searchModel->category_id=Category::getChildIDs($category->id,Category::MODEL_TYPE_BRAND);?>
                <?php $dataProvider = $searchModel->search([]);?>
                <?php //var_dump($searchModel);?>
                <?php $models=$dataProvider->models;?>
				<?php if($models) :?>
				<ul class="users-list clearfix">
					<?php foreach ($models as $model):?>
                    <li>
                      <img class="profile-brand-img img-responsive img-circle" src="<?= html::encode($model->logo)?>" alt="User Image">
                      <a href="<?= Url::to(['brand/view','id'=>$model->id])?>"
						class="users-list-name"><?= html::encode($model->en_name)?></a>
                      <span class="users-list-date"><?= html::encode($model->cn_name)?></span>
                    </li>
                    <?php endforeach;?>                   
                  </ul>
				<?php endif;?>                  
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                	<?php if($dataProvider->pagination):?>
                  		<a href="<?= url::to(['brand/search-by-category','category_id'=>$category->id])?>" class="uppercase">更多...</a>
                  	<?php endif;?>
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
	<?php endforeach;?>
<?php endif;?>
<!-- 分类别显示结束 -->


   


