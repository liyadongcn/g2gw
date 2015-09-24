<?php

namespace backend\controllers;

use Yii;
use common\models\Goods;
use common\models\Comment;
use common\models\Links;
use common\models\base\Model;
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
    
    public function actions()
    {
    	return [
    			'upload' => [
    					'class' => 'kucha\ueditor\UEditorAction',
    					'config' => [
    							"imageUrlPrefix"  => Yii::$app->request->hostInfo,//图片访问路径前缀
    							"imagePathFormat" => "/uploads/goods/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
    					],
    			]
    			/* 'image-upload' => [
    			 'class' => 'vova07\imperavi\actions\UploadAction',
    					'url' =>  'http://back/uploads/posts/', // Directory URL address, where files are stored.
    					'path' => '@backend/web/uploads/posts' // Or absolute path to directory where files are stored.
    			],    */
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
       
        $modelLinks = [new Links()];

        if ($model->load(Yii::$app->request->post())) {
        	
        	$modelLinks = Model::createMultiple(Links::classname());
        	Model::loadMultiple($modelLinks, Yii::$app->request->post());
        	
        	// ajax validation
        	if (Yii::$app->request->isAjax) {
        		Yii::$app->response->format = Response::FORMAT_JSON;
        		return ArrayHelper::merge(
        				ActiveForm::validateMultiple($modelLinks),
        				ActiveForm::validate($model)
        		);
        	}
        	
        	//Get the current user
        	$model->userid=!empty(Yii::$app->user->identity->id)?Yii::$app->user->identity->id:0;
        	 
        	// Get the pictures and save to the album
        	$model->file = UploadedFile::getInstances($model, 'file');
        	
        	// validate all models
        	$valid = $model->validate();
        	$valid = Model::validateMultiple($modelLinks) && $valid;
        	
        	if ($valid) {
        		$transaction = \Yii::$app->db->beginTransaction();
        		try {
        			if ($flag = $model->save(false)) {
        				foreach ($modelLinks as $modelLink) {
        					$modelLink->model_id = $model->id;
        					$modelLink->model_type = MODEL_TYPE_GOODS;
        					if (! ($flag = $modelLink->save(false))) {
        						$transaction->rollBack();
        						break;
        					}
        				}
        			}
        			if ($flag) {
        				$transaction->commit();
        				// save the uploaded images
        				if($model->file){
	        				foreach ($model->file as $key=>$file) {
	        					$key==0?$model->saveToAlbum($file,1):$model->saveToAlbum($file);
	        				}
        				}
        				//set the categories of this model.
        				$model->setCategories();
        				return $this->redirect(['view', 'id' => $model->id]);
        			}
        		} catch (Exception $e) {
        			$transaction->rollBack();
        		}
        	}      	
        	
        } 
        
        	$model->userid=!empty(Yii::$app->user->identity->id)?Yii::$app->user->identity->id:0;
            return $this->render('create', [
                'model' => $model,
            	'modelLinks' => (empty($modelLinks)) ? [new Links] : $modelLinks
            ]);
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
        $modelLinks = $model->links;
        
        if ($model->load(Yii::$app->request->post())) {
        	 
        	// Get deleted links ids
        	$oldIDs = ArrayHelper::map($modelLinks, 'id', 'id');
        	$modelLinks = Model::createMultiple(Links::classname(), $modelLinks);
        	Model::loadMultiple($modelLinks, Yii::$app->request->post());
        	$deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelLinks, 'id', 'id')));
        	 
        	// ajax validation
        	if (Yii::$app->request->isAjax) {
        		Yii::$app->response->format = Response::FORMAT_JSON;
        		return ArrayHelper::merge(
        				ActiveForm::validateMultiple($modelLinks),
        				ActiveForm::validate($model)
        		);
        	}
        
        	// Get the current user
        	$model->userid=!empty(Yii::$app->user->identity->id)?Yii::$app->user->identity->id:0;
        	 
        	// Get the pictures and save to the album
        	$model->file = UploadedFile::getInstances($model, 'file');
        
        	// validate all models
        	$valid = $model->validate();
        	$valid = Model::validateMultiple($modelLinks) && $valid;
        	 
        	if ($valid) {
        		$transaction = \Yii::$app->db->beginTransaction();
        		try {
        			if ($flag = $model->save(false)) {
        				if (! empty($deletedIDs)) {
        					Links::deleteAll(['id' => $deletedIDs]);
        				}
        				foreach ($modelLinks as $modelLink) {
        					$modelLink->model_id = $model->id;
        					$modelLink->model_type = MODEL_TYPE_GOODS;
        					if (! ($flag = $modelLink->save(false))) {
        						$transaction->rollBack();
        						break;
        					}
        				}
        			}
        			if ($flag) {
        				$transaction->commit();
        				// save the loaded images
        				if($model->file){
        					foreach ($model->file as $file) {
        						$model->saveToAlbum($file);
        					}
        				}
        				//set the categories of this model.
        				$model->setCategories();
        				return $this->redirect(['view', 'id' => $model->id]);
        			}
        		} catch (Exception $e) {
        			$transaction->rollBack();
        		}
        	}
        }
        return $this->render('update', [
        		'model' => $model,
        		'modelLinks' => (empty($modelLinks)) ? [new Links] : $modelLinks
        ]);
        
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
