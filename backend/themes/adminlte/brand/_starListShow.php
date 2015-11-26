<?php
/*
 * 显示收藏的品牌列表
 * 每个品牌显示包括：logo、中文名称、英文名称、取消收藏按钮
 * logo显示为圆形
 * logo大致为100*100，logo在左侧，其他信息在logo右侧
 *
 * */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $models common\models\brand */

?>

<?php if($models):?>
<?php foreach ($models as $brand):?>
                        <div class="post">
                        	<div class="user-block">
                        		<img class="img-circle img-bordered-sm" src="<?= html::encode($brand->logo)?>" alt="user image">
		                        <span class="username">
		                          <a href="<?= Url::to(['brand/view','id'=>$brand->id])?>"><?= html::encode($brand->en_name)?></a>
		                          <a href="<?= Url::to(['brand/remove-star','id'=>$brand->id])?>" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
		                        </span>
		                        <span class="description"><?= html::encode($brand->cn_name)?></span>
                            </div>
                        </div>
<?php endforeach;?>                    
<?php endif;?>

