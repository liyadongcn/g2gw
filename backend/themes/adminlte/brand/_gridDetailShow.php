<?php
/*  
 * 每个品牌显示包括：logo、国家、官方旗舰店链接、标签
 * logo大致为300*300，logo在上方，其他信息在logo下方
 * 
 * */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\icons\Icon;

/* @var $this yii\web\View */
/* @var $models common\models\brand */
Icon::map($this, Icon::FI); // Maps the Elusive icon font framework
?>

<?php if($models) :?>
<?php foreach ($models as $model):?>
  	<div class="col-md-4 col-sx-12" >
	<div class="thumbnail">
      		<a href="<?= Url::to(['brand/view','id'=>$model->id])?>"> <img src="<?= html::encode($model->logo)?>"  alt="<?= html::encode($model->en_name.' '.$model->cn_name)?>"></a>
      		<div class="caption">
        	<h3><?= html::encode($model->cn_name)?>
        		<?php if($model->country):?>
        			<a href="<?= url::to(['brand/search-by-country','country_code'=>$model->country_code])?>">
        			<span class="pull-right" data-toggle="tooltip" data-placement="top" title=<?= html::encode($model->country->cn_name)?>><?= Icon::show(strtolower($model->country->alpha2_code), [], Icon::FI) ?></span>
        			</a>
        		<?php endif;?> 
        	</h3>       		
        		<div class="btn-group " role="group" aria-label="...">
									<?php $ecommerces=$model->ecommerces;?>
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
				  					<?php $tagMaps=$model->getTagMaps()->all();?>
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
									<a href="<?= Url::to(['brand/thumbsup','id' => $model->id])?>">
										<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
									</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsup) ?></span>
									<a
										href="<?= Url::to(['brand/thumbsdown','id' => $model->id])?>">
										<span class="glyphicon glyphicon-thumbs-down"
										aria-hidden="true"></span>
									</a> <span class="badge" aria-hidden="true"><?= Html::encode($model->thumbsdown) ?></span>
									<span class="glyphicon glyphicon-comment"
										aria-hidden="true"></span> <span class="badge"
										aria-hidden="true"><?= Html::encode($model->comment_count) ?></span>
									<span class="glyphicon glyphicon-eye-open"></span> <span
										class="badge"><?= Html::encode($model->view_count) ?></span>
									<a href="<?= Url::to(['brand/star','id' => $model->id])?>">
									<?php if($model->isStared()):?>
										<span class="glyphicon glyphicon-star"></span>
									<?php else :?>
										<span class="glyphicon glyphicon-star-empty"></span>
									<?php endif;?>
										
									</a> <span class="badge"><?= Html::encode($model->star_count) ?></span>
				</p>
      		</div>
    	</div>
	</div>	
	<?php endforeach;?>
<?php endif;?>
