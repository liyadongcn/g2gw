<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\bootstrap\Carousel;
use common\models\Brand;
use common\models\Category;
use common\models\Posts;
use common\models\User;
use common\models\Tag;
use common\models\Relationships;
use common\models\RelationshipsMap;
use yii\data\Sort;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '品牌';
$this->params['breadcrumbs'] [] = $this->title;

const ROW_ITEMS_COUNT=3;
?>
    		
<div class="row">
	<!-- 页面左半部分开始 -->
	<div class="col-lg-9 ">
		<div class="brand-index">

		<?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

		</div>
		
<!-- 品牌促销活动轮播开始 -->
<?php $promotions=Posts::getPromotions(10)->all();?>
<?php if($promotions):?>
	<?php foreach ($promotions as $promotion):?>
		<?php $img=$promotion->getAlbumDefaultImg();?>
		<?php if($img):?>		
			<?php $items[]=[
					'content'=>'<a href="'.url::to(['posts/view','id'=>$promotion->id]).'">'.html::img($img->filename).'</a>',
					'caption'=>'<h4 >'.html::encode($promotion->post_title).'</h4>',
					'options'=>'',
				];				
			?>
		<?php endif;?>
	<?php endforeach;?>	
	<?php //var_dump($items);?>
	<?php //die();?>
	<?php echo Carousel::widget(['items'=>$items]);?>
<?php endif;?>
<?php 
// echo Carousel::widget([
// 		'items' => [
// 				// the item contains only the image
// 				'<img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-01.jpg"/>',
// 				// equivalent to the above
// 				['content' => '<img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-02.jpg"/>'],
// 				// the item contains both the image and the caption
// 				[
// 						'content' => '<img src="http://twitter.github.io/bootstrap/assets/img/bootstrap-mdo-sfmoma-03.jpg"/>',
// 						'caption' => '<h4>This is title</h4><p>This is the caption text</p>',
// 						'options' => [],
// 				],
// 		]
// ]);
?>		

<!-- 品牌促销活动轮播结束 -->

<hr>

<!-- 搜索结果数量及排序开始 -->
<?php $sort=$dataProvider->sort;?>
<div class="row ">
<div class="col-md-6 col-sm-12">
<!-- <span class="glyphicon glyphicon-search"><?= html::encode('找到'.$dataProvider->totalCount).'条'?></span> -->
</div>
<div class="col-md-6 col-sm-12">
<p class="action pull-right">
<?php echo $sort->link('view_count') . ' | ' . $sort->link('thumbsup'). ' | ' . $sort->link('star_count'). ' | ' . $sort->link('comment_count'). ' | ' . $sort->link('updated_date');?>
</p>
</div>
</div>
<!-- 搜索结果数量及排序结束 -->

<!-- 搜索结果展示开始 -->
<?php $models=$dataProvider->models;?>
<?php if($models) :?>
<?php $rows=(int)ceil($dataProvider->count/ROW_ITEMS_COUNT);?>
<?php for($i=0;$i<$rows;$i++):?>
	<div class="row">
	<?php for($j=0;$j<ROW_ITEMS_COUNT;$j++):?>
		<?php $modelIndex=$j+$i*ROW_ITEMS_COUNT;?>
		<?php if($modelIndex+1>$dataProvider->count) break;?>
		<div class="col-md-4">
		<div class="thumbnail">
      		<a href="<?= Url::to(['brand/view','id'=>$models[$modelIndex]->id])?>"> <img src="<?= html::encode($models[$modelIndex]->logo)?>" alt="..."></a>
      		<div class="caption">
        	<h3><?= html::encode($models[$modelIndex]->cn_name)?>
        		<?php if($models[$modelIndex]->country):?>
        			<a href="<?= url::to(['brand/search-by-country','country_code'=>$models[$modelIndex]->country_code])?>">
        			<span class="pull-right" data-toggle="tooltip" data-placement="top" title=<?= html::encode($models[$modelIndex]->country->cn_name)?>><?= html::img($models[$modelIndex]->country->flag,['width'=>30])?></span>
        			</a>
        		<?php endif;?> 
        	</h3>       		
        		<div class="btn-group " role="group" aria-label="...">
									<?php $ecommerces=$models[$modelIndex]->ecommerces;?>
									<?php if ($ecommerces) :?>
										
									<?php foreach ($ecommerces as $ecommerce) :?>
										<?php if($ecommerce->accept_order):?>
										<a class="btn btn-success btn-xs"
												href="<?= html::encode($ecommerce->website);?>" target="_blank" role="button"><?= html::encode($ecommerce->name);?></a>
										<?php else :?>
										<a class="btn btn-warning btn-xs"
												href="<?= html::encode($ecommerce->website);?>" target="_blank" role="button"><?= html::encode($ecommerce->name);?></a>
										<?php endif;?>
									<?php endforeach;?>
										
									<?php endif;?>
				</div>
				
				<p>
				  					<?php $tagMaps=$models[$modelIndex]->getTagMaps()->all();?>
				  					<?php if($tagMaps):?>
				  					<hr>
				  					<span class="glyphicon glyphicon-tags">&nbsp;</span>
				  					<?php foreach ($tagMaps as $tagMap):?>  			
				  						<a href="<?= Url::to(['brand/search-by-tag','tagid' =>  $tagMap->tag->id])?>"><span class="label label-default"><?= $tagMap->tag->name?></span></a>
				  					<?php endforeach;?>	
				  					<?php endif;?>		
				</p>
				<hr>
				<p>
									<a href="<?= Url::to(['brand/thumbsup','id' => $models[$modelIndex]->id])?>">
										<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
									</a> <span class="badge" aria-hidden="true"><?= Html::encode($models[$modelIndex]->thumbsup) ?></span>
									<a
										href="<?= Url::to(['brand/thumbsdown','id' => $models[$modelIndex]->id])?>">
										<span class="glyphicon glyphicon-thumbs-down"
										aria-hidden="true"></span>
									</a> <span class="badge" aria-hidden="true"><?= Html::encode($models[$modelIndex]->thumbsdown) ?></span>
									<span class="glyphicon glyphicon-comment"
										aria-hidden="true"></span> <span class="badge"
										aria-hidden="true"><?= Html::encode($models[$modelIndex]->comment_count) ?></span>
									<span class="glyphicon glyphicon-eye-open"></span> <span
										class="badge"><?= Html::encode($models[$modelIndex]->view_count) ?></span>
									<a href="<?= Url::to(['brand/star','id' => $models[$modelIndex]->id])?>">
									<?php if($models[$modelIndex]->isStared()):?>
										<span class="glyphicon glyphicon-star"></span>
									<?php else :?>
										<span class="glyphicon glyphicon-star-empty"></span>
									<?php endif;?>
										
									</a> <span class="badge"><?= Html::encode($models[$modelIndex]->star_count) ?></span>
				</p>
      		</div>
    	</div>
		</div>
	<?php endfor;?>
	</div>
<?php endfor;?>

<?php else:?>
	<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span>抱歉！啥也没找到！</div>
<?php endif;?>

<?php 
// 显示分页
echo LinkPager::widget([
		'pagination' => $dataProvider->getPagination(),
]);
?>
<!-- 搜索结果展示结束 -->

<!-- 马赛克显示效果开始 -->
<?php \yii2masonry\yii2masonry::begin([
    'clientOptions' => [
        'columnWidth' => '_col-md-4',
        'itemSelector' => '._mthumbnail',
        'percentPosition' => true
    ]
]); ?>

<?php \yii2masonry\yii2masonry::end(); ?>
<?php $css= <<<CSS
	._thumbnail { float: left;}
  	._thumbnail.w2 { width: 50%; }
CSS;
$this->registerCss($css);
?>
<!-- 马赛克显示效果结束 -->

</div>
<!-- 页面左半部分结束 -->
	
<!-- 页面右半部分开始 -->
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
                <a href="<?= Url::to(['brand/view','id'=>$brand->id])?>"><?= html::encode($brand->en_name.$brand->cn_name)?></a>
                <span class="pull-right"><a href="<?= Url::to(['brand/remove-star','id'=>$brand->id])?>">取消收藏</a></span>
            </li>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
    </div>
<!--     <div class="panel-footer"> -->
    	<span>
    	<?php echo LinkPager::widget([
            'pagination' => $starBrandProvider->getPagination(),
            ]);
        ?>
    	</span>
<!--     </div> -->
	</div>
	<?php endif;?>
	<?php endif;?>
	<?php endif;?>
<!-- 用户收藏品牌结束 -->
	
<!-- 热门品牌开始 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">热门品牌</h3>
	</div>
	<div class="panel-body">
		<ul class="list-group">
	<?php $hotestBrands=Brand::getHotestBrands(5)->all();?>
	<?php //var_dump($relatedBrands); die();?>
	<?php if($hotestBrands):?>
		<?php foreach ($hotestBrands as $hotestdBrand):?>
			<a href=<?= Url::to(['brand/view','id'=>$hotestdBrand->id])?> class="list-group-item">
			<?= html::encode($hotestdBrand->en_name)?><span class="pull-right"><?= html::encode($hotestdBrand->cn_name)?></span>
			</a>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
	</div>
</div>
<!-- 热门品牌结束 -->


<!-- 热门标签开始 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">热门标签</h3>
	</div>
	<div class="panel-body">
	<?php $hotestTags=Tag::getHotestTags(MODEL_TYPE_BRAND,30)->all();?>
	<?php if($hotestTags):?>
		<p>
		<?php foreach ($hotestTags as $tag):?>			
			<a href="<?= Url::to(['brand/search-by-tag','tagid'=>$tag->id])?>">
			<span class="label label-success"><?= html::encode($tag->name)?>(<?= html::encode($tag->count)?>)
			</span>
			</a>&nbsp;
		<?php endforeach;?>
		</p>
	<?php endif;?>
	</div>
</div>
<!-- 热门标签结束 -->

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
				class="list-group-item"><?= html::encode($brand->en_name)?><span class="pull-right"><?= html::encode($brand->cn_name)?></span></a>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
	</div>
</div>
<!-- 最新品牌结束 -->

	</div>
<!-- 页面右半部分结束 -->
</div>


