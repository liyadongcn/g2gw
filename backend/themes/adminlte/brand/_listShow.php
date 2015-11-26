<?php
/*
 * 每个品牌显示包括：logo、国家、官方旗舰店链接、标签
 * logo大致为100*100，logo在左侧，其他信息在logo右侧
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

<ul class="brands-list brands-list-in-box ">
                    <?php if($models):?>
                        <?php foreach ($models as $model):?>
                        <li class="item">
                        	<div class="brand-img">
                    				<img class="img-responsive " src="<?= html::encode($model->logo)?>" alt="Product Image">
                  			</div>
                  			<div class="brand-info">
                  					<a href=<?= Url::to(['brand/view','id'=>$model->id])?> class="brand-title"><?= html::encode($model->en_name.$model->cn_name)?>
				                    </a>
				                    <span class="brand-description">
				                    <div class="btn-group " role="group" aria-label="...">
									<?php $ecommerces=$model->ecommerces;?>
									<?php if ($ecommerces) :?>										
									<?php foreach ($ecommerces as $ecommerce) :?>
										<?php empty($ecommerce->link_promotion) ? $link=$ecommerce->website : $link=$ecommerce->link_promotion;?>
										<?php if($ecommerce->accept_order):?>
										<a class="btn btn-success btn-xs btn-flat"
												href="<?= html::encode($link);?>" target="_blank" role="button"><?= html::encode($ecommerce->name);?></a>
										<?php else :?>
										<a class="btn btn-warning btn-xs btn-flat"
												href="<?= html::encode($link);?>" target="_blank" role="button"><?= html::encode($ecommerce->name);?></a>
										<?php endif;?>
									<?php endforeach;?>										
									<?php endif;?>
									</div>
                          			<?php if($model->country):?>
        							<a href="<?= url::to(['brand/search-by-country','country_code'=>$model->country_code])?>" data-toggle="tooltip" data-placement="top" title=<?= html::encode($model->country->cn_name)?> class="pull-right btn-box-tool"><?= Icon::show(strtolower($model->country->alpha2_code), [], Icon::FI) ?></a>
        							<?php endif;?>  
                        			</span>
                        			<span class="brand-description">
				  					<?php $tagMaps=$model->getTagMaps()->all();?>
				  					<?php if($tagMaps):?>
				  					<span class="glyphicon glyphicon-tags">&nbsp;</span>
				  					<?php foreach ($tagMaps as $tagMap):?>  			
				  						<a href="<?= Url::to(['brand/search-by-tag','tagid' =>  $tagMap->tag->id])?>"><span class="label label-default"><?= $tagMap->tag->name?></span></a>
				  					<?php endforeach;?>	
				  					<?php endif;?>		
									</span>                   			
                            </div>                            
                        </li>
                        <?php endforeach;?>
   <?php endif;?>
 </ul>
