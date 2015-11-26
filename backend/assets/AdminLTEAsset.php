<?php
/**
 * @link http://www.yiiframework.com/
* @copyright Copyright (c) 2008 Yii Software LLC
* @license http://www.yiiframework.com/license/
*/

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminLTEAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [			
			'adminlte/bootstrap/css/bootstrap.min.css',
			'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css',
			//'adminlte/dist/css/font-awesome.min.css',
			'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
			//'adminlte/dist/css/ionicons.min.css',
			'adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
			'adminlte/dist/css/AdminLTE.min.css',
			'adminlte/dist/css/skins/_all-skins.min.css',
			'adminlte/plugins/iCheck/flat/blue.css',
			'css/site.css',
	];
	public $js = [
			//'adminlte/plugins/jQuery/jQuery-2.1.4.min.js',//开启后select2不工作
			'adminlte/bootstrap/js/bootstrap.min.js',
			//'adminlte/bootstrap/js/bootstrap.js',
			//'adminlte/plugins/fastclick/fastclick.js',
			'adminlte/dist/js/app.min.js',
			//'adminlte/plugins/sparkline/jquery.sparkline.min.js',
			//'adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
			//'adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
			//'adminlte/plugins/slimScroll/jquery.slimscroll.min.js',
			//'adminlte/plugins/chartjs/Chart.min.js',
			//'adminlte/dist/js/pages/dashboard.js',//开启后select2不工作
			//'adminlte/dist/js/demo.js',
			'js/main.js',
	];
	public $depends = [
			'yii\web\YiiAsset',
			//'yii\bootstrap\BootstrapAsset',
	];
}
