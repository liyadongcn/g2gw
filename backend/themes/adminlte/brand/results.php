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
use backend\controllers\BrandController;
use yii\data\Sort;
use common\advertisement\ADManager;
use common\models\helper\BrowserHelper;
use kartik\icons\Icon;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\BrandSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $showStyle 列表显示样式还是格子显示 */

$this->title = '品牌';
$this->params['breadcrumbs'] [] = $this->title;

Icon::map($this, Icon::FI); // Maps the Elusive icon font framework


?>
    		
<div class="row">
<!-- 页面左半部分开始 -->
<div class="col-lg-9 ">

<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">
                  <?= ''?>
                  </h3>                                             
                  <div class="box-tools pull-right">
		                  
		            <a href="<?= url::to(['change-show-style']) ?>">切换显示模式</a>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                <!-- 品牌结果列表开始 -->
				<?php $models=$dataProvider->models;?>
				<?php if($showStyle===BrandController::SHOW_STYLE_LIST):?>
				<!-- 列表显示结果开始 -->
					<ul class="brands-list brands-list-in-box ">
				         <?php if($models):?>
				             <?php echo $this->render('_listShow',['models'=>$dataProvider->models])?>
						<?php else:?>
						<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span>抱歉！啥也没找到！</div>
				        <?php endif;?>
				    </ul>
				<!-- 列表显示结果结束 -->
				<?php else :?>
				<!-- 格子显示结果开始 -->
				<?php if($models) :?>
						<?php echo $this->render('_gridDetailShow',['models'=>$dataProvider->models])?>
						
				<?php else:?>
						<div class="alert alert-danger" role="alert"><span class="glyphicon glyphicon-exclamation-sign"></span>抱歉！啥也没找到！</div>
				<?php endif;?>
				<!-- 格子显示结果结束 -->
				<?php endif;?>
				<!-- 品牌结果列表结束 -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                	<?php 
						// 显示分页
						echo LinkPager::widget([
								'pagination' => $dataProvider->getPagination(),
								'options' => ['class'=>'pager'],
								'maxButtonCount'=>3,
								//'disabledPageCssClass'=>true,
								'nextPageLabel' => '下一页',
								'prevPageLabel' => '上一页',
						]);
						?>
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->


</div>
<!-- 页面左半部分结束 -->
	
<!-- 页面右半部分开始 -->
<div class="col-lg-3 ">
	
<!-- 热门品牌开始 -->
<div class="box box-danger">
	<div class="box-header with-border">
		<h3 class="box-title">热门品牌</h3>
	</div>
	<div class="box-body">
	<?php $hotestBrands=Brand::getHotestBrands(8)->all();?>
	<?php echo $this->render('_gridShow',['models'=>$hotestBrands])?>	
	</div>
</div>
<!-- 热门品牌结束 -->

<!-- 最新品牌开始 -->
<div class="box box-danger">
	<div class="box-header with-border">
		<h3 class="box-title">最新品牌</h3>
	</div>
	<div class="box-body">
	<?php $brands=Brand::getLatestBrands(8)->all();?>
	<?php echo $this->render('_gridShow',['models'=>$brands])?>	
	</div>
</div>
<!-- 最新品牌结束 -->

<!-- 用户收藏品牌开始 -->
	<?php if(!yii::$app->user->isGuest):?>
	<?php $user=User::findIdentity(yii::$app->user->id);?>
	<?php if($user):?>
	<?php $starBrandProvider=$user->getRelationshipModels(Relationships::RELATIONSHIP_STAR, RelationshipsMap::MODEL_TYPE_BRAND);?>
	<?php if($starBrandProvider->totalCount!=0):?>
	<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">收藏的品牌</h3>
        <div class="box-tools pull-right">
            <span data-toggle="tooltip" title="" class="badge bg-yellow" data-original-title="<?= html::encode($starBrandProvider->totalCount)?>"><?= html::encode($starBrandProvider->totalCount)?></span>
        </div>
    </div>
    <div class="box-body">
    	<?php $brands=$starBrandProvider->models?>
    	<?php echo $this->render('_starListShow',['models'=>$brands])?>
        
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
<?php echo ADManager::getAd(ADManager::AD_TAOBAO, ADManager::AD_MOBILE, ADManager::AD_SIZE_320_90)?>
<?php else:?>
<!-- pc device -->
<?php echo ADManager::getAd(ADManager::AD_SOGOU, ADManager::AD_PC, ADManager::AD_SIZE_250_250);?>
<?php echo ADManager::getAd(ADManager::AD_TAOBAO, ADManager::AD_PC, ADManager::AD_SIZE_250_250);?>
<?php endif;?>
<!-- 广告位结束 -->

	</div>
<!-- 页面右半部分结束 -->
</div>


