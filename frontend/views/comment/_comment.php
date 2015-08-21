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
				<?php if($comment->user):?>
					<a href=<?=Url::to(['/user/view','id'=>$comment->userid])?> rel="author" data-original-title="" title="">
					<img class="media-object" src=<?= html::encode($comment->user->face)?> alt=""></a>
				<?php else:?>
					<img class="media-object" src=<?= html::encode(DEFAULT_USER_FACE)?> alt="">
				<?php endif;?>
			</div>
			<div class="media-body">
				<div class="media-heading">
					<?= html::encode($comment->author)?>
					评论于 <?= html::encode($comment->created_date)?>
					<span class="pull-right">
						<a href=<?=Url::to(['/comment/report','id'=>$comment->id])?>>举报</a>
					</span>
				</div>
				<div class="media-content">
					<?php if ($comment->approved === COMMENT_STATUS_APPROVED):?>
						<p> <?= html::encode($comment->content)?></p>
					<?php elseif ($comment->approved === COMMENT_STATUS_REPORTED):?>
						<p> <?= html::encode('内容已被举报！')?></p>
					<?php else: ?>
						<p> <?= html::encode('审核中！！')?></p>
					<?php endif;?>
				</div>
				<div class="hint">
					共 <em><?= html::encode($comment->subCommentsCount)?></em>
					条回复
				</div>
				<?php 
					//$subcomments=$comment->getCommentsList($comment->model_type,$comment->model_id,$comment->id);
					if($comment->approved === COMMENT_STATUS_APPROVED)
					{
						$subcomments=$comment->subcomments;
						echo $this->renderAjax('@app/views/comment/_subcomment.php',['comments'=>$subcomments]);
					}						
				?>
				<div class="media-action">
					<a class="reply-btn" href="#">回复</a>
					<span class="vote pull-right">
						<a class="up" href=<?=Url::to(['/comment/thumbsup','id'=>$comment->id])?> title="" data-toggle="tooltip" data-original-title="顶">
							<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"><em><?= Html::encode($comment->thumbsup)?>&nbsp;</em></span></a>						
						
						<a class="down" href=<?=Url::to(['/comment/thumbsdown','id'=>$comment->id])?> title="" data-toggle="tooltip" data-original-title="踩">
							<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"><em><?= Html::encode($comment->thumbsdown)?>&nbsp;</em></span>	</a>				
					</span>
				</div>
			</div>
		</li>	
		<?php endforeach;?>		
<?php endif;?>

