<?php
use yii\helpers\Html;
use yii\helpers\Url;
//use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\bootstrap\Carousel;
use kartik\widgets\ActiveForm;
use common\models\Posts;

/* @var $this yii\web\View */
/* @var $model */


$this->title = Yii::$app->name.'-'.'搜索官网商品';
?>
<div class="solr-search">

    <h3><?= Html::encode('官网搜') ?></h3>

     <?php $form = ActiveForm::begin([
     		'method'=>'get',
     		//'type' => ActiveForm::TYPE_INLINE,
     		'fullSpan' => 12,
     		'formConfig' => ['showErrors' => true],     		
     ]); ?>

    <?= $form->field($model, 'keyWords', [
	    'addon' => [
	        'append' => [
	            'content' => Html::submitButton('搜索一下', ['class'=>'btn btn-primary']), 
	            'asButton' => true
	        ]
	    ]
	])->textInput()->label(false) ?>

    <?php ActiveForm::end(); ?>
	<p>
        	所有的搜索结果将来自商家的官网信息.
    </p>
    <p>
        	请仔细填写关键词，以便系统为您找到最合适的商品.
    </p>
    
    <!-- 品牌促销活动轮播开始 -->
	<?php //if ($this->beginCache('CACHE_SOLR_POST_PROMOTION', ['duration' => 60])): ?>
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
	<?php //$this->endCache();?>		
	<?php //endif;?>
	<!-- 品牌促销活动轮播结束 -->
    
</div>