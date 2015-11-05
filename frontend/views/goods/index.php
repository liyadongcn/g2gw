<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\helper\BrowserHelper;
use common\models\goods;
use common\models\Category;
use common\models\User;
use common\models\tag;
use common\models\Relationships;
use common\models\RelationshipsMap;
use common\models\helper\TimeHelper;
use common\advertisement\ADManager;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::$app->name.'-'.'精品 超值 特惠';
$this->params['breadcrumbs'][] = $this->title;

const ROW_ITEMS_COUNT=2;
?>

<div class="row">
<!-- 页面左半部分开始 -->
	<div class="col-lg-9 ">
	<div class="goods-index">

<!-- 搜索结果数量及排序开始 -->
<?php //$sort=$dataProvider->sort;?>
<!-- <div class="row"> -->
<!-- <div class="col-md-6 col-sm-12"> -->
<!-- <span class="glyphicon glyphicon-search"><?= html::encode('找到'.$dataProvider->totalCount).'条'?></span> -->
<!-- </div> -->
<!-- <div class="col-md-6 col-sm-12"> -->
<!-- 	<p class="action pull-right"> -->
<?php //echo $sort->link('view_count') . ' | ' . $sort->link('thumbsup'). ' | ' . $sort->link('star_count'). ' | ' . $sort->link('comment_count'). ' | ' . $sort->link('updated_date');?>   
<!-- 	</p> -->
<!-- </div> -->
<!-- </div> -->
<!-- 搜索结果数量及排序结束 -->

<?php $models=$dataProvider->models;?>
<?php if($models) :?>
<ul class="list-unstyled">	
  	<?php foreach ($models as $model):?>
  		<li >
  		<div class="panel panel-default">
			<div class="panel-body">
				<div class="media">
					<div class="media-left media-middle">
						<a href=<?= Url::to(['goods/view','id'=>$model->id])?>>
						<?php $image=$model->albumDefaultImg;?>
						<?php if($image):?>
								<img class=" media-object img-rounded" src="<?= html::encode($image->filename)?>"	alt="<?= html::encode($model->title)?>" width="120px">
						<?php //else :?>
<!-- 								<img class=" media-object img-rounded" src=""	alt="..." width="200"> -->
						<?php endif;?>
						</a>
					</div>
					<div class="media-body">
						<a href="<?= Url::to(['goods/view','id'=>$model->id])?>">
							<?php if(BrowserHelper::is_mobile()):?>
							<!-- mobile device display -->
							<h4 class="media-heading"><?= html::encode($model->title)?></h4>
							<?php else :?>
							<!-- pc device display -->
							<h3 class="media-heading"><?= html::encode($model->title)?></h3>
							<?php endif;?>							
						</a>
						<p>
							<?= html::encode(mb_substr( strip_tags($model->description), 0, 100, 'utf-8').'……')?>
							<span><a href="<?= Url::to(['goods/view','id'=>$model->id])?>">
							[详细]</a></span>						
						</p>
						
							<div class="btn-group pull-right" role="group" aria-label="...">
							<?php if ($model->url) :?>
								<a class="btn btn-default" href="<?= html::encode($model->url);?>" target="_blank" role="button"><span class="">去购买</span></a>
							<?php endif;?>
							<?php $links = $model->links?>
							<?php if($links):?>
								<?php foreach ($links as $link):?>
								<a class="btn btn-default " target="_blank" href=<?= Url::to($link->link)?>><span class=""><?= $link->link_name ?></span></a>
								<?php endforeach;?>
							<?php endif;?>
							</div>
						
					</div>					
				</div>
				<!-- <div > -->
				<div class="row">
				<div class="col-md-6 col-sm-6">
					<div class='text-left'>
	  					<?php $tagMaps=$model->getTagMaps()->all();?>
	  					<?php if($tagMaps):?>
	  					<span class="glyphicon glyphicon-tags">&nbsp;</span>
	  					<?php foreach ($tagMaps as $tagMap):?>  			
	  						<a href="<?= Url::to(['goods/search-by-tag','tagid' =>  $tagMap->tag->id])?>"><span class="label label-default"><?= $tagMap->tag->name?></span></a>
	  					<?php endforeach;?>	
	  					<?php endif;?>		
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<p class='text-right'>
						<a href="<?= Url::to(['goods/thumbsup','id' => $model->id])?>"> <span
							class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
						</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsup) ?></span>
						<a href="<?= Url::to(['goods/thumbsdown','id' => $model->id])?>">
							<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
						</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsdown) ?></span>
						<span class="glyphicon glyphicon-comment"
							aria-hidden="true"></span> <span class="badge" aria-hidden="true"><?= Html::encode($model->comment_count) ?></span>
						<span class="glyphicon glyphicon-eye-open"></span> <span
							class="badge"><?= Html::encode($model->view_count) ?></span>
						<a href="<?= Url::to(['goods/star','id' => $model->id])?>">
							<?php if($model->isStared()):?>
										<span class="glyphicon glyphicon-star"></span>
									<?php else :?>
										<span class="glyphicon glyphicon-star-empty"></span>
									<?php endif;?>
							</a> <span class="badge"><?= Html::encode($model->star_count) ?></span>
							<span class="glyphicon glyphicon-time"></span> <span class="badge" aria-hidden="true"><?= html::encode(TimeHelper::getRelativeTime($model->updated_date))?></span>
					</p>
				</div>
				</div>
			<!-- </div> -->
			</div>
			
		</div>
	</li>
  <?php endforeach;?>
  
</ul>
<?php else:?>
	<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span>抱歉！啥也没找到！</div>
<?php endif;?>

<?php 
// 显示分页
echo LinkPager::widget([
		'pagination' => $dataProvider->getPagination(),
]);
?>

</div>
	</div>
<!-- 页面左半部分结束 -->
<!-- 页面右半部分开始 -->
<div class="col-lg-3 ">

<!-- 热门标签开始 -->
<!-- <div class="panel panel-primary"> -->
<!-- 	<div class="panel-heading"> -->
<!-- 		<h3 class="panel-title">热门标签</h3> -->
<!-- 	</div> -->
<!-- 	<div class="panel-body"> -->
	<?php $hotestTags=Tag::getHotestTags(MODEL_TYPE_GOODS,30)->all();?>
	<?php if($hotestTags):?>
		<?php foreach ($hotestTags as $tag):?>			
			<?php //echo Url::to(['goods/search-by-tag','tagid'=>$tag->id])?>
			<?php //echo html::encode($tag->name)?>
			<?php //echo html::encode($tag->count)?>
		<?php endforeach;?>
	<?php endif;?>
<!-- 	</div> -->
<!-- </div> -->
<!-- 热门标签结束 -->

<!-- 用户收藏的商品开始 -->
	<?php if(!yii::$app->user->isGuest):?>
	<?php $user=User::findIdentity(yii::$app->user->id);?>
	<?php if($user):?>
	<?php $starGoodsProvider=$user->getRelationshipModels(Relationships::RELATIONSHIP_STAR, RelationshipsMap::MODEL_TYPE_GOODS);?>
	<?php if($starGoodsProvider->totalCount!=0):?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">收藏的商品<span class="badge pull-right"><?= html::encode($starGoodsProvider->totalCount)?></span></h3>
    </div>
    <div class="panel-body">
    <!-- <ul class="list-group"> -->
    	<?php $goods=$starGoodsProvider->models;?>
        <?php if($goods):?>
        <?php $rows=(int)ceil($starGoodsProvider->count/ROW_ITEMS_COUNT);?>
		<?php for($i=0;$i<$rows;$i++):?>
		<div class="row">
		<?php for($j=0;$j<ROW_ITEMS_COUNT;$j++):?>
		<?php $goodsIndex=$j+$i*ROW_ITEMS_COUNT;?>
		<?php if($goodsIndex+1>$starGoodsProvider->count) break;?>
			<div class="col-xs-6">
            <?php $goodsOne=$goods[$goodsIndex]?>
            <div class="thumbnail">
            	<a href="<?= Url::to(['goods/view','id'=>$goodsOne->id])?>" >
				<?php if($image=$goodsOne->albumDefaultImg):?>
      				<img src="<?= html::encode($image->filename)?>" alt="...">
      			<?php endif;?>
      			<p class="small">
      				<?= html::encode($goodsOne->title)?>
      			</p>
      			</a>
      			<p class="text-right">
      				<a class="btn btn-primary btn-xs" href="<?= Url::to(['goods/remove-star','id'=>$goodsOne->id])?>">取消收藏</a>
      			</p>
      		</div>
      		</div>
            <?php endfor;?>
            </div>
           <?php endfor;?>
        <?php endif;?>
       
    <!-- </ul> -->
    </div>
    <div class="panel-footer">
        	<span>
    	<?php echo LinkPager::widget([
            'pagination' => $starGoodsProvider->getPagination(),
            ]);
        ?>
    	</span>
    </div>
</div>
	<?php endif;?>
	<?php endif;?>
	<?php endif;?>
<!-- 用户收藏的商品结束 -->

<!-- 热门商品开始 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">热门商品</h3>
	</div>
	<div class="panel-body">
	<!-- <ul class="list-group"> -->
	<?php $hotestGoods=Goods::getHotestGoods(5)->all();?>
	<?php if($hotestGoods):?>
		<?php foreach ($hotestGoods as $goods):?>
			<a href="<?= Url::to(['goods/view','id'=>$goods->id])?>" >
			<div class="thumbnail">
				<?php if($image=$goods->albumDefaultImg):?>
      				<img src="<?= html::encode($image->filename)?>" alt="...">
      			<?php endif;?>
      			<p class="small">
      				<?= html::encode($goods->title)?>
      			</p>
      		</div>
			</a>
		<?php endforeach;?>
	<?php endif;?>
	<!-- </ul> -->
	</div>
</div>
<!-- 热门商品结束 -->

<!-- 最新商品开始 -->
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">最新商品</h3>
	</div>
	<div class="panel-body">
		<!-- <ul class="list-group"> -->
	<?php $latestGoods=Goods::getLatestGoods(5)->all();?>
	<?php //var_dump($relatedBrands); die();?>
	<?php if($latestGoods):?>
		<?php foreach ($latestGoods as $goods):?>
			<a href="<?= Url::to(['goods/view','id'=>$goods->id])?>" >
			<div class="thumbnail">
				<?php if($image=$goods->albumDefaultImg):?>
      				<img src="<?= html::encode($image->filename)?>" alt="...">
      			<?php endif;?>
      			<p class="small">
      				<?= html::encode($goods->title)?>
      			</p>
      		</div>
			</a>
		<?php endforeach;?>
	<?php endif;?>
	<!-- </ul> -->
	</div>
</div>
<!-- 最新商品结束 -->

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





