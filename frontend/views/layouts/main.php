<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use frontend\models\Search;
use common\models\Category;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => '去官网购物G2GW',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                //['label' => 'Home', 'url' => ['/site/index']],
                //['label' => 'About', 'url' => ['/site/about']],
                //['label' => 'Contact', 'url' => ['/site/contact']],                
            ];
            if (Yii::$app->user->isGuest) {
//             	$signupUrl=Url::to('index.php?r=site/signup');
//                 $menuItems[] = ['label' => '注册', 
//                 	'linkOptions'=>['onclick'=>'signup("'.$signupUrl.'")','class' => 'active']                		
//                 ];
            	//$menuItems[] = ['label' => 'Solr Testing', 'url' => ['/site/comment']];
                $menuItems[] = [
                		'label' => '注册','url' => ['/site/signup']
                ];
                $menuItems[] = ['label' => '登录', 'url' => ['/site/login'],'linkOptions' => ['class' => 'active']];
            } else {
				//$menuItems[] = ['label' => 'Solr Testing', 'url' => ['/site/comment']];
//                 $menuItems[] = [
//                     'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
//                     'url' => ['/site/logout'],
//                     'linkOptions' => ['data-method' => 'post']
//                 ];
                $menuItems[] = [
                 'label' => Yii::$app->user->identity->username,
                 'items' => 
                    [
                    	['label' => '<span class="glyphicon glyphicon-user"></span>个人主页', 'url' => ['/user/view','id'=>yii::$app->user->id]],
                   		'<li class="divider"></li>',
                   		//'<li class="dropdown-header">Dropdown Header</li>',                 		
                    	['label' =>'<span class="glyphicon glyphicon-cog"></span>帐户设置','url' => '#'],
                    	['label' =>'<span class="glyphicon glyphicon-calendar"></span>我的签到','url' => '#'],
                    	['label' =>'<span class="glyphicon glyphicon-edit"></span>报告品牌','url' => ['/brand/create']],
                    	['label' =>'<span class="glyphicon glyphicon-star"></span>我的收藏','url' => '#'],
                    	['label' =>'<span class="glyphicon glyphicon-piggy-bank"></span>我的积分','url' => '#'],
                    	'<li class="divider"></li>',
                    	['label' =>'<span class="glyphicon glyphicon-log-out"></span>退出','url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post']],
                  	]
                ];
            }
         ?>
			<p class="navbar-text">最新的官网购物信息</p>
<!-- 分类菜单开始 -->			
			<?php  $catMenuItems=Category::getCategoryAsMenuItems1( 0, yii::$app->session->get('SEARCH_MODEL_TYPE'));?>
			<?php echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' =>$catMenuItems,
				'encodeLabels' => false,
            ]);
            ?>
<!-- 分类菜单结束 -->			
            
            <?php echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            	'encodeLabels' => false,
            ]);
            ?>
<!-- 搜索框开始             -->
            <form class="navbar-form navbar-right" role="search" >
            <div class="form-group">
           
			<div class="input-group">
			<span class="input-group-addon">
			 <select name="Search[model_type]">
<?php $searchModelType=yii::$app->session->get('SEARCH_MODEL_TYPE');?>
<?php switch($searchModelType):?>
<?php case MODEL_TYPE_BRAND:?>
			  <option value="brand" selected="selected">品牌</option>
			  <option value="goods">商品</option>
			  <option value="posts">促销活动及购物经验</option>	
			  <option value="solr">官网商品</option>	
			  <?php break;?>
<?php case MODEL_TYPE_GOODS:?>
			  <option value="brand">品牌</option>
			  <option value="goods" selected="selected">商品</option>
			  <option value="posts">促销活动及购物经验</option>	
			  <option value="solr">官网商品</option>	
			  <?php break;?>
<?php case MODEL_TYPE_POSTS:?>
			  <option value="brand">品牌</option>
			  <option value="goods">商品</option>
			  <option value="posts" selected="selected">促销活动及购物经验</option>	
			  <option value="solr">官网商品</option>	
			  <?php break;?>
<?php case MODEL_TYPE_SOLR:?>
			  <option value="brand">品牌</option>
			  <option value="goods">商品</option>
			  <option value="posts">促销活动及购物经验</option>	
			  <option value="solr" selected="selected">官网商品</option>	
			  <?php break;?>
<?php default:?>
			  <option value="brand" selected="selected">品牌</option>
			  <option value="goods">商品</option>
			  <option value="posts">促销活动及购物经验</option>	
			  <option value="solr">官网商品</option>	
			  <?php break;?>
<?php endswitch;?>		
			</select>
			</span>
	            <input type="text" name="Search[keyWords]" class="form-control" placeholder="找出你的最爱......">
	           
	            <span class="input-group-btn">
	            	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
	            <span>
	        </div>
            </div>
            </form>
<!--  搜索框结束           -->
            <?php 
            NavBar::end();
        ?>

    	<div class="container">
<!--     	<div class="row"> -->
<!--     	<div class="col-md-1"> -->
    	<?php //echo $this->renderFile('@app/views/layouts/sidebar.php');?> 
<!-- 分类菜单开始 -->
    <?php //echo $this->renderFile('@app/views/layouts/category.php');?> 
<!-- 分类菜单结束 -->
<!--     	</div> -->
<!--     	<div class="col-md-11"> -->

	    	<?php 
//	    	echo  Breadcrumbs::widget([
// 	            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
// 	        ]) 
?>
	        <?= Alert::widget() ?>
	        <?= $content ?>
<!--     	</div> -->
<!--     	</div> -->
        </div>
	</div>

	<footer class="footer">
		<div class="container">
			<p class="pull-left">&copy; My Company <?= date('Y') ?></p>
			<p class="pull-right"><?= Yii::powered() ?></p>
		</div>
	</footer>

    <?php 
    	/* 
    	 *  This is the modal for the signup
    	 *  
    	 *  */
	    Modal::begin([
	    		'header' => '<h2>Sign up</h2>',
	    		'id'=>'signupModal',
	    		'size'=>'md',
	    		//'toggleButton' => ['label' => 'click me'],
	    ]);
	    
	    echo "<div id='modalSignupContent'></div>";
	    
	    Modal::end();    
    ?>


    <?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
