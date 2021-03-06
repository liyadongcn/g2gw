<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use backend\models\backend\models;
use common\models\AuthItem;
use common\models\AuthAssignment;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $modelAuthItems = AuthItem::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        	
        	//Get the uploaded file instance
        	$model->file = UploadedFile::getInstance($model, 'file');
        	 
        	if ($model->file) {
        		$model->file->saveAs('uploads\\user\\' . $model->username. '.' . $model->file->extension);
        		$model->face='uploads\\user\\' . $model->username. '.' . $model->file->extension;
        	}
        	        	
        	
        	$model->setPassword($model->password);
        	$model->generateAuthKey();
        	//$model->password='';
            //$model->permissions=$_POST['User']['permissions'];
        
        	if($model->save())
        	{

                $model->setAuthAssignments();
        		return $this->redirect(['view', 'id' => $model->id]);
        	}
        	
        }  
        return $this->render('create', ['model' => $model,'modelAuthItems' => $modelAuthItems]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelAuthItems = AuthItem::find()->all();
        $model->permissions=ArrayHelper::map($model->authAssignments,'item_name','item_name');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
        	//Get the uploaded file instance
        	$model->file = UploadedFile::getInstance($model, 'file');
        	
        	if ($model->file && $model->validate()) {
        		$model->file->saveAs('uploads\\user\\' . $model->username. '.' . $model->file->extension);
        		$model->face='uploads\\user\\' . $model->username. '.' . $model->file->extension;
        	}
        
        	$model->setPassword($model->password);
        	$model->generateAuthKey();
        	//$model->password='';
        	
        	
        	
       		if($model->save())
        	{
        		$model->setAuthAssignments();
        		return $this->redirect(['view', 'id' => $model->id]);
        	}
        	
        } 
        
        return $this->render('update', ['model' => $model,'modelAuthItems' => $modelAuthItems]);
        
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
