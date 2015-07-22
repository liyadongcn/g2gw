<?php
use frontend\models\Search;
//use yii\widgets\ActiveForm;
//use yii\widgets\ActiveField;
use kartik\widgets\ActiveForm;

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel  */
/* @var $dataProvider  */

$this->title = 'My Yii Application';
?>

<div class="search">

    <?php 
//     	$form = ActiveForm::begin([
//         'action' => ['index'],
//         'method' => 'get',
//     	//'type' => ActiveForm::TYPE_INLINE,
//     	'options'=> ['class'=>'navbar-form navbar-left','role'=>'search']
//     ]); 
    	?>
     
     <?php 
//      echo $form->field($searchModel, 'model_type')->label('')->dropDownList(
//     												$searchModel->getDropDownListData('model_type'),
//     		                                        ['prompt' => '选择......']
    		
//     		); ?>
    		

    <?php  
//     echo $form->field($searchModel, 'keyWords', [
//     'addon' => [
//         'append' => [
//             'content' => Html::submitButton('搜索', ['class'=>'btn btn-default']), 
//             'asButton' => true
//         ]
//     ]
// ])->label('')->textInput(['placeholder'=>'搜索你的最爱']) ?>
    
   
    <?php //ActiveForm::end(); ?>

</div>

<div class="clearfix">
<?php switch ($searchModel->model_type):?>
<?php case MODEL_TYPE_BRAND:?>
	<?php echo $this->render('@app/views/brand/index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);?>
	<?php break;?>
<?php case MODEL_TYPE_GOODS: ?>
	<?php echo $this->render('@app/views/goods/index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);?>
	<?php break;?>
<?php case MODEL_TYPE_POSTS: ?>
	<?php echo $this->render('@app/views/posts/index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);?>
	<?php break;?>
<?php case MODEL_TYPE_SOLR: ?>
	<?php echo $this->render('@app/views/solr/index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);?>
	<?php break;?>
<?php default:?>
<?php endswitch;?>
</div>


<!-- <div class="site-index">


	<div class="jumbotron">
		<h1>Congratulations!</h1>

		<p class="lead">You have successfully created your Yii-powered
			application.</p>

		<p>
			<a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get
				started with Yii</a>
		</p>
	</div>

	<div class="body-content">

		<div class="row">
			<div class="col-lg-4">
				<h2>Heading</h2>

				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
					eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
					ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
					aliquip ex ea commodo consequat. Duis aute irure dolor in
					reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
					pariatur.</p>

				<p>
					<a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii
						Documentation &raquo;</a>
				</p>
			</div>
			<div class="col-lg-4">
				<h2>Heading</h2>

				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
					eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
					ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
					aliquip ex ea commodo consequat. Duis aute irure dolor in
					reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
					pariatur.</p>

				<p>
					<a class="btn btn-default"
						href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a>
				</p>
			</div>
			<div class="col-lg-4">
				<h2>Heading</h2>

				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
					eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
					ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
					aliquip ex ea commodo consequat. Duis aute irure dolor in
					reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
					pariatur.</p>

				<p>
					<a class="btn btn-default"
						href="http://www.yiiframework.com/extensions/">Yii Extensions
						&raquo;</a>
				</p>
			</div>
		</div>

	</div>


</div>
 -->