<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\yii\web;
use frontend\models\WechatCallbackapiTest;

/**
 * WxController implements the actions for searching through the solr.
 */
 


class WxController extends Controller
{

	public function behaviors()
	{
		return [
				'access' => [
						'class' => AccessControl::className(),
						'only' => ['index'],
						'rules' => [
								[
										'actions' => ['index'],
										'allow' => true,
										'roles' => ['?','@'],
								],
						],
				],
				'verbs' => [
						'class' => VerbFilter::className(),
						'actions' => [
								'index' => ['get','post'],
						],
				],
		];
	}

	/**
	 * 
	 * @return mixed
	 */
	public function actionIndex()
	{
		//define your token
		define("TOKEN", "123");
		$wechatObj = new WechatCallbackapiTest();
		$wechatObj->valid();
		//$wechatObj->responseMsg();
		
		/* $msgType=yii::$app->request->post('MsgType');
		echo $msgType;
		echo '<br>';
		echo 'hhhhhh'; */
		/* switch($msgType)
		{
			case 'text':
				echo $msgType;
				break;
			case '':
				break;
				
		} */
		
	}
	
	public function actionMessage()
	{
		//define your token
		//define("TOKEN", "123");
		$wechatObj = new WechatCallbackapiTest();
		//$wechatObj->valid();
		$wechatObj->responseMsg();
	
		/* $msgType=yii::$app->request->post('MsgType');
			echo $msgType;
			echo '<br>';
		echo 'hhhhhh';  */
		/* switch($msgType)
			{
			case 'text':
			echo $msgType;
			break;
			case '':
			break;
	
		} */
	
	}

}
