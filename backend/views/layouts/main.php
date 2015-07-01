<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

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
                'brandLabel' => 'G2GW',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse ', //navbar-fixed-top
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

     <div class="container-fluid">
     <div class="row">
        <div class="col-lg-2"><!--left part-->
        	<div class="list-group">
        		<a class="list-group-item list-group-item-success" href=<?= url::to(['/goods'])?>>商品管理（Goods）</a>
        		<a class="list-group-item " href=<?= url::to(['/pricehistory'])?>>&nbsp;&nbsp;--商品价格（PriceHistory）</a>
				<a class="list-group-item list-group-item-success" href=<?= url::to(['/brand'])?>>品牌管理（Brand）</a>
				<a class="list-group-item " href=<?= url::to(['/ecommerce'])?>>&nbsp;&nbsp;--品牌电商网站管理（Ecommerce）</a>
				<a class="list-group-item " href=<?= url::to(['/country'])?>>&nbsp;&nbsp;--品牌所属国家（Country）</a>
				<a class="list-group-item " href=<?= url::to(['/company'])?>>&nbsp;&nbsp;--品牌运营公司管理（Company）</a>
				<a class="list-group-item list-group-item-success" href=<?= url::to(['/posts'])?>>发帖管理（Posts）</a>
				<a class="list-group-item list-group-item-success" href=<?= url::to(['/comment'])?>>评论管理（Comment）</a>
                <a class="list-group-item list-group-item-success" href=<?= url::to(['/category'])?>>分类管理（Category）</a>
                <a class="list-group-item " href=<?= url::to(['/category-map'])?>>&nbsp;&nbsp;--分类映射（CategoryMap）</a>
				<a class="list-group-item list-group-item-success" href=<?= url::to(['/album'])?>>相册管理（Album）</a>
				<a class="list-group-item list-group-item-success" href=<?= url::to(['/tag'])?>>标签（Tag）</a>
				<a class="list-group-item " href=<?= url::to(['/tagmap'])?>>&nbsp;&nbsp;--标签映射管理（Tagmap）</a>
				<a class="list-group-item list-group-item-success" href=<?= url::to(['/user'])?>>用户管理（User）</a>
				<a class="list-group-item " href=<?= url::to(['/relationships'])?>>&nbsp;&nbsp;--用户关系管理（Relationships）</a>
				<a class="list-group-item " href=<?= url::to(['/relationships-map'])?>>&nbsp;&nbsp;--用户关系映射管理（RelationshipsMap）</a>
                <a class="list-group-item list-group-item-success" href=<?= url::to(['/auth-item'])?>>用户权限管理（AuthItem）</a>
                <a class="list-group-item " href=<?= url::to(['/auth-assignment'])?>>&nbsp;&nbsp;--分配用户权限（AuthAssignment）</a>
        	</div>
        </div>
        <div class="col-lg-10"><!--right part  -->
        	  <?= Breadcrumbs::widget([
			            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
			       		 ]) ?>       	
        	 <?= $content ?>        	
        </div>      
      </div>
    </div>
   </div>
    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
 
</body>
</html>
<?php $this->endPage() ?>
