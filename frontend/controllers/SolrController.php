<?php
namespace frontend\controllers;

use Yii;
use backend\models\SolrSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\yii\web;

/**
 * SolrController implements the actions for searching through the solr.
 */
class SolrController extends Controller
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
										'roles' => ['?'],
								],
						],
				],
				'verbs' => [
						'class' => VerbFilter::className(),
						'actions' => [
								'delete' => ['post'],
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
		//This will tell the main layout the current search model type and reset the selection input for searching.
		//$session=yii::$app->session->set('SEARCH_MODEL_TYPE',MODEL_TYPE_SOLR);
		
		return $this->render('error', [
				'name' => '提示',
				'message' => '搜索服务器正在建设中.....',
		]);
		
	/* 	$searchModel = new SolrSearch();
		
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
		]); */
	}

}
