<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\data\Sort;
use common\models\Brand;
use common\models\User;
use common\models\Relationships;
use common\models\RelationshipsMap;

/* @var $this yii\web\View */
$this->title = '官网商品';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
	<!-- 页面左半部分开始 -->
	<div class="col-lg-9 ">

<div class="solr-Response">

<p>所有商品信息来自官网</p>
  
<?php $models=$dataProvider->models;?>
<?php if($models) :?>
<!-- 搜索结果总数开始 -->
	<?= html::encode('总计:'.$dataProvider->totalCount)?>
<!-- 搜索结果总数结束 -->
<!-- 排序开始 -->
    <div class="pull-right">
    <?php //$sort=$dataProvider->sort;?>
	<?php //echo $sort->link('id');?>
    </div>
<!-- 排序结束     -->
<ul class="list-group">
    
    <?php foreach ($models as $model):?>
<!--         <div class="panel panel-default"> -->
<!--             <div class="panel-body"> -->
<!--                 <div class="media"> -->
<!--                     <div class="media-left media-middle"> -->
                        
<!--                     </div> -->
<!--                     <div class="media-body"> -->
    <li class="list-group-item">
    					<p>
                        <a href="<?php echo Html::encode($model->url)?>">
                            <h5 ><?php echo html::encode($model->title)?></h5>
                        </a>
                        </p>
                        <p >
                            <?php echo html::encode('信息时间:'.$model->tstamp)?>
                            <?php //$propertyNames=$model->getPropertyNames();?>
                            <?php //foreach ($propertyNames as $property):?>
                            	<?php //echo html::encode('"'.$property.'"-')?>
                            	<?php //if(is_array($model->offsetGet($property))):?>
                            		<?php //echo html::encode( '"'.serialize($model->offsetGet($property)).'"')?>
                            	<?php //else :?>
                            		<?php //echo html::encode( '"'.$model->offsetGet($property).'"')?>
                            	<?php //endif;?>
                            <?php //endforeach;?>
                            <?php //print_r($model);?>
                             
                        </p>
                        
<!--                     </div> -->
<!--                     <p class="text-right"> -->
                            <?php //if ($model->url) :?>
                            <?php //endif;?>
<!--                     </p> -->
<!--                 </div> -->
<!--             </div> -->
<!--             <div class="panel-footer"> -->
                
<!--             </div> -->
<!--         </div> -->
    </li>
  	<?php endforeach;?>
  
</ul>
<?php else:?>
    <div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span>抱歉！啥也没找到！</div>
<?php endif;?>
    
<!-- 分页开始 -->
    <?php 
		echo LinkPager::widget([
			'pagination' => $dataProvider->getPagination(),
		]);
	?>
<!-- 分页结束 -->
</div>
</div>
<!-- 页面左半部分结束-->

<div class="col-lg-3 ">

<!-- 用户收藏品牌开始 -->
	<?php if(!yii::$app->user->isGuest):?>
	<?php $user=User::findIdentity(yii::$app->user->id);?>
	<?php if($user):?>
	<?php $starBrandProvider=$user->getRelationshipModels(Relationships::RELATIONSHIP_STAR, RelationshipsMap::MODEL_TYPE_BRAND);?>
	<?php if($starBrandProvider->totalCount!=0):?>
	<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">收藏的品牌<span class="badge pull-right"><?= html::encode($starBrandProvider->totalCount)?></span></h3>
    </div>
    <div class="panel-body">
    <ul class="list-group">
    	<?php $brands=$starBrandProvider->models?>
        <?php if($brands):?>
            <?php foreach ($brands as $brand):?>
            <li class="list-group-item">
                <a href="<?= Url::to(['brand/view','id'=>$brand->id])?>"><?= html::encode($brand->en_name)?></a>
                <span class="pull-right"><a href="<?= Url::to(['brand/remove-star','id'=>$brand->id])?>">取消收藏</a></span>
            </li>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
    </div>
    <div class="panel-footer">
    	<span>
    	<?php echo LinkPager::widget([
            'pagination' => $starBrandProvider->getPagination(),
            ]);
        ?>
    	</span>
    </div>
	</div>
	<?php endif;?>
	<?php endif;?>
	<?php endif;?>
<!-- 用户收藏平拍结束 -->
	
<!-- 热门品牌开始 -->
<div class="panel panel-danger">
	<div class="panel-heading">
		<h3 class="panel-title">热门品牌</h3>
	</div>
	<div class="panel-body">
		<ul class="list-group">
	<?php $hotestBrands=Brand::getHotestBrands(5)->all();?>
	<?php //var_dump($relatedBrands); die();?>
	<?php if($hotestBrands):?>
		<?php foreach ($hotestBrands as $hotestdBrand):?>
			<a href="<?= Url::to(['brand/view','id'=>$hotestdBrand->id])?>"
				class="list-group-item"><?= html::encode($hotestdBrand->en_name)?></a>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
	</div>
</div>
<!-- 热门品牌结束 -->

<!-- 最新品牌开始 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">最新品牌</h3>
	</div>
	<div class="panel-body">
		<ul class="list-group">
	<?php $brands=Brand::getLatestBrands(5)->all();?>
	<?php //var_dump($relatedBrands); die();?>
	<?php if($brands):?>
		<?php foreach ($brands as $brand):?>
			<a href="<?= Url::to(['brand/view','id'=>$brand->id])?>"
				class="list-group-item"><?= html::encode($brand->en_name)?></a>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
	</div>
</div>
<!-- 最新品牌结束 -->

	</div>
<!-- 页面右半部分结束 -->

</div>