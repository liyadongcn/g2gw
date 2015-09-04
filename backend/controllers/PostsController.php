<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use common\models\Posts;
use common\models\Comment;
use common\models\Album;
use yii\web\UploadedFile;
use backend\models\PostsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotAcceptableHttpException;
use yii\web\ForbiddenHttpException;

/**
 * PostsController implements the CRUD actions for Posts model.
 */
class PostsController extends Controller
{
    public function behaviors()
    {
        return [
    		'access' => [
    				'class' => AccessControl::className(),
    				'rules' => [
    						[
	    						'actions' => ['index','view'],
	    						'allow' => true,
	    						'roles' => ['@'],
    						],
    						[
    							'actions' => ['update','create'],
    							'allow' => true,
    							'roles' => ['author','editor','admin'],
    						],
                            [
                                'actions' => ['delete'],
                                'allow' => true,
                                'roles' => ['editor','admin'],
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
     * Lists all Posts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Posts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$model= $this->findModel($id);
    	$model->updateCounters(['view_count'=>1]);
    	$model->comment=new Comment();
    	
    	if ($model->comment->load(Yii::$app->request->post()) && $model->comment->validate())
    	{
    		$model->submitComment();
    	}
    	
        return $this->render('view', [
            'model' =>$model,
        ]);
    }

    /**
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Posts();
        //$model->post_type=Posts::POST_TYPE_ARTICLE;
        $model->post_status=POST_STATUS_PUBLISH;

        if ($model->load(Yii::$app->request->post())) {
        	
        	//Get the current user
        	$model->userid=!empty(Yii::$app->user->identity->id)?Yii::$app->user->identity->id:0;
        	 
        	// Get the pictures and save to the album
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
        } else {
        	$model->userid=!empty(Yii::$app->user->identity->id)?Yii::$app->user->identity->id:0;
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
    	if (\Yii::$app->user->can('updatePosts', ['post' => $model])) {
    	// update post
    		$model->categories=ArrayHelper::map($model->getCategories()->all(), 'name','id');
    		
    		if ($model->load(Yii::$app->request->post())) {
    			 
    			//Get the current user
    			$model->userid=!empty(Yii::$app->user->identity->id)?Yii::$app->user->identity->id:0;
    		
    			// Get the pictures and save to the album
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
    		} else {
    			return $this->render('update', [
    					'model' => $model,
    			]);
    		}
		}
		else {
			throw new ForbiddenHttpException('没有权限修改！');
		}
        
    }

    /**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
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
