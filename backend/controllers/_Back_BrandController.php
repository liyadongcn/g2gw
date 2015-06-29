<?php

namespace backend\controllers;

use Yii;
use common\models\Brand;
use common\models\Comment;
use common\models\Ecommerce;
use common\base\Model;
use backend\models\BrandSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends Controller
{
	const UPLOAD_FILE_PATH='uploads\\brand\\logo\\';
	
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
        $modelEcommerce = new Ecommerce();

        if ($model->load(Yii::$app->request->post()) && $modelEcommerce->load(Yii::$app->request->post())) {
        	
        	//Get the uploaded file instance
        	$model->file = UploadedFile::getInstance($model, 'file');
        	
        	if ($model->file && $model->validate()) {
        		$model->file->saveAs(self::UPLOAD_FILE_PATH . $model->en_name. '.' . $model->file->extension);
        		$model->logo=self::UPLOAD_FILE_PATH. $model->en_name. '.' . $model->file->extension;
        	}
        	
        	$model->save();
        	
        	if ($modelEcommerce->validate()){
        		$modelEcommerce->brand_id=$model->id;
        		$modelEcommerce->save();
        	}
        	
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            	'modelEcommerce' => $modelEcommerce,
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
        $modelEcommerce = new Ecommerce();

        if ($model->load(Yii::$app->request->post()) && $modelEcommerce->load(Yii::$app->request->post())) {
        	
        	//Get the uploaded file instance
        	$model->file = UploadedFile::getInstance($model, 'file');
        	
        	if ($model->file && $model->validate()) {
        		$model->file->saveAs(self::UPLOAD_FILE_PATH . $model->en_name. '.' . $model->file->extension);
        		$model->logo=self::UPLOAD_FILE_PATH. $model->en_name. '.' . $model->file->extension;
        	}
        	
        	$model->save();
        	
        	if ($modelEcommerce->validate() && $modelEcommerce->name && $modelEcommerce->website){
        		$modelEcommerce->brand_id=$model->id;
        		$modelEcommerce->save();
        	}
        	
            return $this->redirect(['view', 'id' => $model->id]);
            
        } else {
            return $this->render('update', [
                'model' => $model,
            	'modelEcommerce' => $modelEcommerce,
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
}
