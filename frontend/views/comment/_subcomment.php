<?php

use yii\helpers\Html;
use yii\helpers\url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Comment */

/* 
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title; 
*/
/* function getSSubCommentListView($view,$comment)
{

} */

?>
<?php if ($comments!==null) :?>
	<?php foreach ($comments as $comment) :?>
				<div class="media">
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
							<?= Html::encode($comment->author)?>
							回复于 <?= html::encode($comment->created_date)?>
							<span class="pull-right">
								<a class="reply-btn" href="#">回复</a>
							</span>
						</div>
						<p><?= html::encode($comment->content)?></p>
						<?php 
							//$subcomments=$comment->getCommentsList($comment->model_type,$comment->model_id,$comment->id);
							$subcomments=$comment->getSubComments();
						    echo $this->renderAjax('@app/views/comment/_subcomment.php',['comments'=>$subcomments]);
						?>
					</div>
				</div>
		<?php endforeach;?>
<?php endif;?>
		


