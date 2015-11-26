<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Album;
use common\models\Comment;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $model common\models\Goods */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="goods-view">

    <!-- <h1><?php //echo  Html::encode($this->title) ?></h1> -->
    
     <div class="jumbotron " >
	  <h1 class='text-left'><?= Html::encode($model->title) ?></h1>
	  <p class='text-left'><a class="btn btn-primary btn-lg" href="<?= Html::encode($model->url) ?>" role="button">去购买</a></p>
	</div>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<!-- 商品图片列表开始 -->
	<?php
		$album=$model->album;
		if(!empty($album)){
			echo '<div class="row">';			
			foreach ($album as $image){
				echo '<div class="col-sm-6 col-md-3 col-lg-2"">';
				echo '<div class="thumbnail">';
				echo '<img src="'.$image->filename.'" class="img-responsive img-thumbnail" alt="Responsive image" width="200">';
				echo '<div class="caption">';
				//echo '<h3>Thumbnail label</h3>';
				//echo '<p>...</p>';
				//echo '<a href="index.php?r=album/delete&id='.$image->id.'" class="btn btn-default btn-xs" role="button">删除</a></p>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}		
			echo '</div>';
		}
	?>
<!-- 商品图片列表结束 -->
   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'brand_id',
            'code',
            'description:ntext',
            'thumbsup',
            'thumbsdown',
            'url:url',
            'title',
            'comment_status',
            'comment_count',
            'created_date',
            'updated_date',
            'star_count',
            'recomended_count',
            'view_count',
        ],
    ]) ?>
    
<!-- 商品分类列表开始 -->
    <div class='panel panel-default goods-category'>
        <div class="panel-heading">
            <h3 class="panel-title">分类</h3>
        </div>
        <div class="panel-body">
        	<?php $categoryMaps=$model->getCategoryMap()->all();?>
        		<?php if($categoryMaps):?>
        			<?php foreach ($categoryMaps as $categoryMap): ?>
        <!-- 			echo $this->renderAjax('@app/views/category-map/view.php',['model'=>$categoryMap]); -->
        			<!-- 	<blockquote class="bg-primary"> -->
        				    <span ><?= $categoryMap->category->name?></span>
        				<!-- </blockquote> -->
        			<?php endforeach;?>
        		<?php endif;?>
        </div>
	</div>
<!-- 商品分类列表结束	 -->


<div class='goods-comment_status'>
	  <blockquote class="bg-default">
		<?php 
			echo $model->getDropDownListData('comment_status')[$model->comment_status];
		?>
	  </div>
    </blockquote>

</div>

<!-- 商品标签列表开始 -->
    <div class="panel panel-default">
  		<div class="panel-heading">
   			<h3 class="panel-title">标签</h3>
  		</div>
  		<div class="panel-body">
  			<?php 
  				$tagMaps=$model->getTagMaps()->all();
  				foreach ($tagMaps as $tagMap)
  			:?>
  				<span class="label label-success"><?= $tagMap->tag->name?></span>
  			<?php endforeach;?>			
<!-- 			<span class="label label-primary">Primary</span> -->
<!-- 			<span class="label label-success">Success</span> -->
<!-- 			<span class="label label-info">Info</span> -->
<!-- 			<span class="label label-warning">Warning</span> -->
<!-- 			<span class="label label-danger">Danger</span> -->
  		</div>
	</div>
<!-- 商品标签列表结束	 -->
	
<!-- 相关商品开始 -->
<?php $relatedGoods=$model->getRelatedGoods(10)->all();?>
			<div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">相关商品</h3>
                  <div class="box-tools pull-right">
                    <span class="label label-danger"> <?= html::encode(count($relatedGoods))?></span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body ">
                	<ul class="products-list product-list-in-box">
	                <?php if($relatedGoods):?>
	                <?php foreach ($relatedGoods as $goods):?>
	                <li class="item">
	                    <div class="product-img">
	                    	<img src="<?= html::encode($goods->albumDefaultImg->filename)?>" alt="Product Image">
	                  	</div>
	                  	<div class="product-info">
	                  		<a href=<?= Url::to(['goods/view','id'=>$goods->id])?> class="product-title"><?= html::encode($goods->title)?></a>
	                  		<span class='product-description'><?= html::encode($goods->updated_date)?></span>
	                    </div>
	                 </li>
	                <?php endforeach;?>
					<?php endif;?>  
					</ul>
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="javascript::" class="uppercase">View All Users</a>
                </div>
                <!-- /.box-footer -->
              </div>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">相关商品</h3>
	</div>
	<div class="panel-body">
		<ul class="list-group">
	<?php $relatedGoods=$model->getRelatedGoods(5)->all();?>
	<?php //var_dump($relatedBrands); die();?>
	<?php if($relatedGoods):?>
		<?php foreach ($relatedGoods as $goods):?>
			<a href="<?= Url::to(['goods/view','id'=>$goods->id])?>" class="list-group-item">
			<div class="row">
            		<div class="col-md-9"><?= html::encode($goods->title)?></div>
            		<div class="col-md-3"><span class='glyphicon glyphicon-time pull-right'><?= html::encode($goods->updated_date)?></span></div>
             </div>
			</a>
		<?php endforeach;?>
	<?php endif;?>
	</ul>
	</div>
</div>
<!-- 相关商品结束 -->
	
	
<!-- 评论列表开始 -->
<div id="comments">
	<div class="page-header">
		<h2>
			共 <em><?= Html::encode($model->comment_count)?></em>
			条评论
		</h2>
		<ul id="w0" class="nav nav-tabs nav-sub">
			<li class="active">
				<a href="/tutorial/332#comments">默认排序</a>
			</li>
			<li>
				<a href="/tutorial/332?sort=desc#comments">最后评论</a>
			</li>
		</ul>
	</div>

	<ul id="w1" class="media-list">
	<?php
        $dataProvider=$model->getComments(); 
        $comments=$dataProvider->models;        
        echo $this->renderAjax('@app/views/comment/_comment.php',['comments'=>$comments]);
        echo LinkPager::widget([
        'pagination' => $dataProvider->getPagination(),
        ]);     
    ?>
	</ul>
</div>
<!-- 评论列表结束 -->
<!-- 评论发表框开始 -->
<div class="comment-form">

    <?php $form = ActiveForm::begin(['action' => ['comment/create'],'method'=>'post']); ?>
    
    <?php $modelComment=new Comment();?>
    
    <?php echo $form->field($modelComment, 'model_type')->hiddenInput(['value'=>MODEL_TYPE_GOODS])->label(false) ?>
    
    <?php echo $form->field($modelComment, 'model_id')->hiddenInput(['value'=>$model->id])->label(false)  ?>

    <?php echo $form->field($modelComment, 'content')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('发表评论', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <?php //隐藏的回复框?>
    
     <?php $form = ActiveForm::begin(['action' => ['comment/create'],'method'=>'post','options'=>['class' => 'reply-form hidden']]); ?>
     
     <?php $modelSubComment=new Comment();?>
     
    <?php echo $form->field($modelSubComment, 'model_type')->hiddenInput(['value'=>MODEL_TYPE_GOODS])->label(false) ?>
    
    <?php echo $form->field($modelSubComment, 'model_id')->hiddenInput(['value'=>$model->id])->label(false)  ?>
     
    <?php echo $form->field($modelSubComment, 'parent_id')->hiddenInput(['class'=>'parent_id'])->label(false) ?>

    <?php echo $form->field($modelSubComment, 'content')->textarea(['rows' =>3])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('回复评论', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<!-- 评论发表结束 -->