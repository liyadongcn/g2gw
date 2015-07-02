<?php

use yii\helpers\Html; 
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

/* 
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; 
*/


 ?>
 <?php if ($comments!==null) : ?>
 	<?php foreach ($comments as $comment) :?>
		<li class="media" data-key="<?= $comment->id?>">
			<div class="media-left">
				<a href=<?=Url::to(['/user/view','id'=>$comment->userid])?> rel="author" data-original-title="" title="">
				<?php if($comment->user):?>
					<img class="media-object" src=<?= html::encode($comment->user->face)?> alt=""></a>
				<?php endif;?>
			</div>
			<div class="media-body">
				<div class="media-heading">
					<a href=<?=Url::to(['/user/view','id'=>$comment->userid])?> rel="author" data-original-title="" title=""><?= html::encode($comment->author)?></a>
					评论于 <?= html::encode($comment->created_date)?>
					<span class="pull-right">
						<a>举报</a>
					</span>
				</div>
				<div class="media-content">
					<p> <?= html::encode($comment->content)?></p>
				</div>
				<div class="hint">
					共 <em><?= html::encode($comment->subCommentsCount)?></em>
					条回复
				</div>
				<?php 
					//$subcomments=$comment->getCommentsList($comment->model_type,$comment->model_id,$comment->id);	
					$subcomments=$comment->subcomments;
					echo $this->renderAjax('@app/views/comment/_subcomment.php',['comments'=>$subcomments]);	
				?>
				<div class="media-action">
					<a class="reply-btn" href="#">回复</a>
					<span class="vote pull-right">
						<a class="up" href="/vote?type=comment&amp;action=up&amp;id=502" title="" data-toggle="tooltip" data-original-title="顶"></a>
							<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"><em><?= Html::encode($comment->thumbsup)?>&nbsp;</em></span>						
						
						<a class="down" href="/vote?type=comment&amp;action=down&amp;id=502" title="" data-toggle="tooltip" data-original-title="踩"></a>
							<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"><em><?= Html::encode($comment->thumbsdown)?>&nbsp;</em></span>					
					</span>
				</div>
			</div>
		</li>	
		<?php endforeach;?>		
<?php endif;?>

