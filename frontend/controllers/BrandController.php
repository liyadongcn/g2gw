<?php

namespace frontend\controllers;

use Yii;
use common\models\Brand;
use common\models\Comment;
use common\models\Tag;
use backend\models\BrandSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\web\yii\web;
use common\models\Category;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends Controller
{
	const UPLOAD_FILE_PATH='uploads\\brand\\';
	
    public function behaviors()
    {
        return [
        		'access' => [
        				'class' => AccessControl::className(),
        				'only' => ['star'],
        				'rules' => [
        						[
        								'actions' => ['star'],
        								'allow' => true,
        								'roles' => ['@'],
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
     * Lists all Brand models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BrandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Brand model.
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
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brand();

        if ($model->load(Yii::$app->request->post())) {
        	
        	//Get the uploaded file instance
        	$model->file = UploadedFile::getInstance($model, 'file');
        	
        	if ($model->file && $model->validate()) {
        		$model->file->saveAs(self::UPLOAD_FILE_PATH . $model->en_name. '.' . $model->file->extension);
        		$model->logo=self::UPLOAD_FILE_PATH. $model->en_name. '.' . $model->file->extension;
        	}
        	
        	$model->save();
        	
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
        	
        	//Get the uploaded file instance
        	$model->file = UploadedFile::getInstance($model, 'file');
        	
        	if ($model->file && $model->validate()) {
        		$model->file->saveAs(self::UPLOAD_FILE_PATH . $model->en_name. '.' . $model->file->extension);
        		$model->logo=self::UPLOAD_FILE_PATH. $model->en_name. '.' . $model->file->extension;
        	}
        	
        	$model->save();
        	
            return $this->redirect(['view', 'id' => $model->id]);
            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Brand model.
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
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Brand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
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
    

    /**
     * Star an existing  model.
     * If star is successful, the browser will be redirected to where the page from.
     * @param integer $id
     * @return mixed
     */
    public function actionStar($id)
    {
    	$model=$this->findModel($id);
    	$model->addStar();
    
    	return $this->redirect(yii::$app->request->referrer);
    }
    
    /**
     * Remove the Star from an existing  model.
     * If unstar is successful, the browser will be redirected to where the page from.
     * @param integer $id
     * @return mixed
     */
    public function actionRemoveStar($id)
    {
    	$model=$this->findModel($id);
    	$model->removeStar();
    
    	return $this->redirect(yii::$app->request->referrer);
    }
    
    /**
     * Search the models with the same tag id.
     * 
     * @param integer $tagid
     * @return mixed
     */
    public function actionSearchByTag($tagid)
    {
    	$searchModel = new BrandSearch();
    	$searchModel->tagid=$tagid;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Search the models with the same category id.
     *
     * @param integer $tagid
     * @return mixed
     */
    public function actionSearchByCategory($category_id)
    {
    	$searchModel = new BrandSearch();
    	$searchModel->category_id=Category::getChildIDs($category_id,Category::MODEL_TYPE_BRAND);
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    	return $this->render('index', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
}
