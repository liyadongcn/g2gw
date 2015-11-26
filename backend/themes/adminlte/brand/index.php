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
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Brand', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
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
                <?php //echo $this->render('_gridShow',['models'=>$dataProvider->models])?>
                <?php echo $this->render('_listShow',['models'=>$dataProvider->models])?>
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


   


