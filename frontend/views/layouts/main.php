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
<meta name="keywords" content="去官网购物,去官网,官网购,购物导航,购物决策,购物搜索"/>
<meta name="description" content="购物导航网站 汇集各大品牌 引导用户到厂家的官方网站购物 我们不卖东西 我们让购物更有保障" />
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?69390d9765f773424e6912ceecbe0ba3";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<meta property="qc:admins" content="146706762767277636" />
<meta property="wb:webmaster" content="ef03646278077715" />

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => '去官网购物&nbsp;&nbsp;&nbsp;<small>最新的官网购物信息</small>',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-default navbar-fixed-top',
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
				//$menuItems[] = ['label' => 'Solr Testing', 'url' => ['/site/solr']];
				//$menuItems[] = ['label' => 'Masonry Testing', 'url' => ['/site/masonry']];
            	//$menuItems[] = ['label' => 'WeChat Testing', 'url' => ['/wx/message']];
//                 $menuItems[] = [
//                     'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
//                     'url' => ['/site/logout'],
//                     'linkOptions' => ['data-method' => 'post']
//                 ];
                $menuItems[] = [
                 //'label' => Yii::$app->user->identity->username,
                 'label' => html::img(Yii::$app->user->identity->face,['alt'=>Yii::$app->user->identity->username]),
                		'linkOptions' => ['class' => 'avatar'],
                 'items' => 
                    [
                    	['label' => '<span class="glyphicon glyphicon-user"></span>个人主页', 'url' => ['/user/view','id'=>yii::$app->user->id]],
                   		'<li class="divider"></li>',
                   		//'<li class="dropdown-header">Dropdown Header</li>',                 		
                    	//['label' =>'<span class="glyphicon glyphicon-cog"></span>帐户设置','url' => '#'],
                    	//['label' =>'<span class="glyphicon glyphicon-calendar"></span>我的签到','url' => '#'],
                    	['label' =>'<span class="glyphicon glyphicon-edit"></span>推荐品牌','url' => ['/brand/create']],
                    	['label' =>'<span class="glyphicon glyphicon-edit"></span>推荐商品','url' => ['/goods/create']],
                    	['label' =>'<span class="glyphicon glyphicon-edit"></span>推荐活动及文章','url' => ['/posts/create']],
                    	//['label' =>'<span class="glyphicon glyphicon-star"></span>我的收藏','url' => '#'],
                    	//['label' =>'<span class="glyphicon glyphicon-piggy-bank"></span>我的积分','url' => '#'],
                    	'<li class="divider"></li>',
                    	['label' =>'<span class="glyphicon glyphicon-log-out"></span>退出','url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post']],
                  	]
                ];
            }
         ?>
<!-- 			<p class="navbar-text">最新的官网购物信息</p> -->
			
<!-- 分类菜单开始 -->
			<?php $searchModelType=yii::$app->session->get('SEARCH_MODEL_TYPE');?>
			<?php  $catMenuItems=Category::getCategoryAsMenuItems1( 0, $searchModelType);?>
			<?php echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' =>$catMenuItems,
				'encodeLabels' => false,
            ]);
            ?>
<!-- 分类菜单结束 -->
            
<!-- 主菜单开始 -->
            <?php echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' =>[
                		['label' =>'品牌','url' => ['/brand/index']],
                		['label' =>'精品','url' => ['/goods/index']],
                		['label' =>'活动','url' => ['/posts/index']],
                		['label' =>'官网搜','url' => ['/solr/index']],
            	],
				'encodeLabels' => false,
            ]);
            ?>
<!-- 主菜单结束 -->
            
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
<?php switch($searchModelType):?>
<?php case MODEL_TYPE_BRAND:?>
<input type="text" name="Search[keyWords]" class="form-control" placeholder="搜索品牌......">
			  <?php break;?>		
<?php case MODEL_TYPE_GOODS:?>
<input type="text" name="Search[keyWords]" class="form-control" placeholder="搜索网友推荐官网精品......">
			  <?php break;?>
<?php case MODEL_TYPE_POSTS:?>
<input type="text" name="Search[keyWords]" class="form-control" placeholder="搜索官网活动及购物经验......">
			  <?php break;?>
<?php case MODEL_TYPE_SOLR:?>
<input type="text" name="Search[keyWords]" class="form-control" placeholder="搜索官网全部商品......">
			  <?php break;?>
<?php default:?>
			  <?php break;?>
<?php endswitch;?>		            
	           
	            <span class="input-group-btn">
	            	<button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
	            </span>
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
			<p class="pull-left">&copy; G2GW.cn <?= date('Y') ?> 京ICP备13027276号</p>
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
