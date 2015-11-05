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
use common\advertisement\ADManager;
use common\models\helper\BrowserHelper;
use kartik\icons\Icon;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name.'-'.'品牌';
$this->params['breadcrumbs'] [] = $this->title;

Icon::map($this, Icon::FI); // Maps the Elusive icon font framework

// 每行显示品牌的数量
const ROW_ITEMS_COUNT=3;
?>
    		
<div class="row">
	<!-- 页面左半部分开始 -->
	<div class="col-lg-9 ">
		<div class="brand-index">

		<?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

		</div>
		
<!-- 品牌促销活动轮播开始 -->
<?php //if ($this->beginCache('CACHE_POST_PROMOTION', ['duration' => 60])): ?>
<?php $promotions=Posts::getPromotions(10)->all();?>
<?php if($promotions):?>
	<?php foreach ($promotions as $promotion):?>
		<?php $img=$promotion->getAlbumDefaultImg();?>
		<?php if($img):?>		
			<?php $items[]=[
					'content'=>'<a href="'.url::to(['posts/view','id'=>$promotion->id]).'">'.html::img($img->filename,['alt'=>$promotion->post_title]).'</a>',
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
<?php //$this->endCache();?>		
<?php //endif;?>
<!-- 品牌促销活动轮播结束 -->

<hr>

<!-- 搜索结果数量及排序开始 -->
<?php //$sort=$dataProvider->sort;?>
<!-- <div class="row "> -->
<!-- <div class="col-md-6 col-sm-12"> -->
<!-- <span class="glyphicon glyphicon-search"><?= html::encode('找到'.$dataProvider->totalCount).'条'?></span> -->
<!-- </div> -->
<!-- <div class="col-md-6 col-sm-12"> -->
<!-- <p class="action pull-right"> -->
<?php //echo $sort->link('view_count') . ' | ' . $sort->link('thumbsup'). ' | ' . $sort->link('star_count'). ' | ' . $sort->link('comment_count'). ' | ' . $sort->link('updated_date');?>
<!-- </p> -->
<!-- </div> -->
<!-- </div> -->
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
      		<a href="<?= Url::to(['brand/view','id'=>$models[$modelIndex]->id])?>"> <img src="<?= html::encode($models[$modelIndex]->logo)?>" alt="<?= html::encode($models[$modelIndex]->en_name.' '.$models[$modelIndex]->cn_name)?>"></a>
      		<div class="caption">
        	<h3><?= html::encode($models[$modelIndex]->cn_name)?>
        		<?php if($models[$modelIndex]->country):?>
        			<a href="<?= url::to(['brand/search-by-country','country_code'=>$models[$modelIndex]->country_code])?>">
        			<span class="pull-right" data-toggle="tooltip" data-placement="top" title=<?= html::encode($models[$modelIndex]->country->cn_name)?>><?= Icon::show(strtolower($models[$modelIndex]->country->alpha2_code), [], Icon::FI) ?></span>
        			</a>
        		<?php endif;?> 
        	</h3>       		
        		<div class="btn-group " role="group" aria-label="...">
									<?php $ecommerces=$models[$modelIndex]->ecommerces;?>
									<?php if ($ecommerces) :?>										
									<?php foreach ($ecommerces as $ecommerce) :?>
										<?php empty($ecommerce->link_promotion) ? $link=$ecommerce->website : $link=$ecommerce->link_promotion;?>
										<?php if($ecommerce->accept_order):?>
										<a class="btn btn-success btn-xs"
												href="<?= html::encode($link);?>" target="_blank" role="button"><?= html::encode($ecommerce->name);?></a>
										<?php else :?>
										<a class="btn btn-warning btn-xs"
												href="<?= html::encode($link);?>" target="_blank" role="button"><?= html::encode($ecommerce->name);?></a>
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

<!-- 马赛克显示效果结束 -->

</div>
<!-- 页面左半部分结束 -->
	
<!-- 页面右半部分开始 -->
	<div class="col-lg-3 ">

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
			<a  class="btn btn-success btn-xs" href="<?= Url::to(['brand/search-by-tag','tagid'=>$tag->id])?>">
			<?= html::encode($tag->name)?><span class="badge"><?= html::encode($tag->count)?>
			</span>
			</a>&nbsp;
		<?php endforeach;?>
		</p>
	<?php endif;?>
	</div>
</div>
<!-- 热门标签结束 -->
	
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
	
<!-- 广告位开始 -->
<?php if(BrowserHelper::is_mobile()):?>
<!-- mobile device -->
<?php echo ADManager::getAd(ADManager::AD_JD, ADManager::AD_MOBILE, ADManager::AD_SIZE_336_280);?>
<?php echo ADManager::getAd(ADManager::AD_TAOBAO, ADManager::AD_MOBILE, ADManager::AD_SIZE_320_90)?>
<?php else:?>
<!-- pc device -->
<?php echo ADManager::getAd(ADManager::AD_SOGOU, ADManager::AD_PC, ADManager::AD_SIZE_250_250);?>
<?php echo ADManager::getAd(ADManager::AD_TAOBAO, ADManager::AD_PC, ADManager::AD_SIZE_250_250);?>
<?php echo ADManager::getAd(ADManager::AD_JD, ADManager::AD_PC, ADManager::AD_SIZE_250_250);?>
<?php endif;?>
<!-- 广告位结束 -->

	</div>
<!-- 页面右半部分结束 -->
</div>


