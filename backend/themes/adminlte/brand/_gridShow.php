<?php
/*
 * 每个品牌显示包括：logo、中文名称、英文名称
 * logo显示为圆形
 * logo大致为100*100，logo在上方，其他信息在logo下方
 *
 * */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $models common\models\brand */

?>

<?php if($models) :?>
<ul class="users-list clearfix">
	<?php foreach ($models as $model):?>
    <li><img
		class="profile-brand-img img-responsive img-circle"
		src="<?= html::encode($model->logo)?>" alt="User Image"> <a
		href="<?= Url::to(['brand/view','id'=>$model->id])?>"
		class="users-list-name"><?= html::encode($model->en_name)?></a>
		<?php if(empty($model->cn_name)):?>
			<span class="users-list-date">&nbsp;</span>
		<?php else :?>
			<span class="users-list-date"><?= html::encode($model->cn_name)?></span>
		<?php endif;?>
		
	</li>
    <?php endforeach;?>                   
</ul>
<?php endif;?>
<!-- /.users-list -->
