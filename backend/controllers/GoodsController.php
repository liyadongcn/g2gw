<?php

namespace backend\controllers;

use Yii;
use common\models\Goods;
use common\models\Comment;
use backend\models\GoodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\Album;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;


/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model= $this->findModel($id);
        $model->updateCounters(['view_count'=>1]);
        $model->comment=new Comment();
        //$model->file=$model->getAlbum();
        
        if ($model->comment->load(Yii::$app->request->post()) && $model->comment->validate())
        {
        	$model->submitComment();
        }
         
        return $this->render('view', [
        		'model' =>$model,
        ]);
    }

    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goods();
        $model->loadDefaultValues();
        //$model->comment_status=Goods::COMMENT_STATUS_OPEN;
       
        if ($model->load(Yii::$app->request->post())) {
        	// Get the goods pictures and save to the album
        	$model->file = UploadedFile::getInstances($model, 'file');        	
        	if ($model->save() && $model->validate()) 
        	{
        		if($model->file)
        		{
        			foreach ($model->file as $file)
        			{
        				$model->saveToAlbum($file);
        			}
        		}
        		//set the categories of this model.
        		$model->setCategories();
        		return $this->redirect(['view', 'id' => $model->id]);
        	}
            
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->categories=ArrayHelper::map($model->getCategories()->all(), 'name','id');
        
        if ($model->load(Yii::$app->request->post())) {
        	// Get the goods pictures and save to the album
        	$model->file = UploadedFile::getInstances($model, 'file');        	
        	if ($model->save() && $model->validate()) {
        		if($model->file){
        			foreach ($model->file as $file) {
        				$model->saveToAlbum($file);
        			}
        		}
        		//set the categories of this model.
        		$model->setCategories();
        		return $this->redirect(['view', 'id' => $model->id]);
        	}
        	else{
        		return $this->render('error',['name'=>'商品信息修改失败','message'=>'数据验证或保存错误！'.implode('|',$model->errors)]);
        	}
            
        } else {        	
        	//$model->file=$model->getAlbum();
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	//$this->findModel($id)->deleteAlbum();
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * Thumbsup an existing Comment model.
     * If thumbsup is successful, the browser will be redirected to where the page from.
     * @param integer $id
     * @return mixed
     */
    public function actionThumbsup($id)
    {
    	$model=$this->findModel($id);
    	$model->updateCounters(['thumbsup'=>1]);
    
    	return $this->redirect(yii::$app->request->referrer);
    }
    
    /**
     * Thumbsdown an existing Comment model.
     * If Thumbsdown is successful, the browser will be redirected to where the page from.
     * @param integer $id
     * @return mixed
     */
    public function actionThumbsdown($id)
    {
    	$model=$this->findModel($id);
    	$model->updateCounters(['thumbsdown'=>1]);
    
    	return $this->redirect(yii::$app->request->referrer);
    }
}
