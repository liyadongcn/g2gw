<?php

use yii\helpers\Html;
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
						<a href="/user/27646" rel="author" data-original-title="" title="">
							<img class="media-object" src="/uploads/avatar/000/02/76/46_avatar_small.jpg" alt="webclz"></a>
					</div>
					<div class="media-body">
						<div class="media-heading">
							<a href="/user/27646" rel="author" data-original-title="" title=""><?= Html::encode($comment->author)?></a>
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
		


