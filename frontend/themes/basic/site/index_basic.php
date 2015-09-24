<?php
use yii\bootstrap\Carousel;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\Posts;

?>
<!-- 显示活动及促销轮播开始  -->
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
<!-- 显示活动及促销轮播结束 -->