<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\models\AuthItem;
use common\models\AuthAssignment;
use common\components\CropAvatar;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
    		'access' => [
    				'class' => AccessControl::className(),
    				'rules' => [
    						[
	    						'actions' => ['view'],
	    						'allow' => true,
	    						'roles' => ['@'],
    						],
    						[
								'actions' => ['update','change-avatar','update-password'],
								'allow' => true,
								'roles' => ['author'],
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
            $model->permissions=$_POST['User']['permissions'];
        
        	if($model->save())
        	{

                if($model->permissions)
                {
                    foreach ($model->permissions as $permission) {
                        $authAssignment=new AuthAssignment();
                        $authAssignment->item_name=$permission;
                        $authAssignment->user_id=$model->id;
                        $authAssignment->save();
                    }
                }
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
        $model->scenario='UpdateProfile';
        
        if (\Yii::$app->user->can('updateUser', ['user' => $model])) {
        	// update user basic information
	        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
	        	
	       		if($model->save())
	        	{
	        		return $this->redirect(['view', 'id' => $model->id]);
	        	}
	        } 
	        return $this->render('update', ['model' => $model]);
        }
        else {
        	throw new ForbiddenHttpException('没有权限修改！');
        }
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
    
    /**
     * Update the avatar using the cropbox widget but it is not avilable for the mobile phone.
     * 
     * @param integer $id of the user
     * @return \yii\base\string
     */
    public function actionUpdateAvatar($id)
    {
    	$model = $this->findModel($id);
    	$model->scenario='UpdateAvatar';
    	
    	if (\Yii::$app->user->can('updateUser', ['user' => $model])) {
    		// update userself avatar
	    	if ($model->load(Yii::$app->request->post())) {
	    		//Get the uploaded file instance
	    		$model->file = UploadedFile::getInstance($model, 'file');
	    		if($model->save())
	    		{
	    			return $this->render('view', ['model' => $model,]);
	    		}
	    	}
	    	return $this->render('avatar', ['model' => $model]);
	    	}
	    else {
	    	throw new ForbiddenHttpException('没有权限修改！');
	    }	    
    }
    
    /**
     * Update the user password.
     *
     * @param integer $id of the user
     * @return \yii\base\string
     */
    public function actionUpdatePassword($id)
    {
    	$model = $this->findModel($id);
        $model->scenario='UpdatePassword';
        $model->password='';

        if (\Yii::$app->user->can('updateUser', ['user' => $model])) {
        	// update user self password
	        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
	        	
	        	$model->setPassword($model->password);
	        	
	       		if($model->save(false))
	        	{
	        		return $this->redirect(['view', 'id' => $model->id]);
	        	}
	        	
	        }         
	        return $this->render('update_password', ['model' => $model]);
	    }
        else {
        	throw new ForbiddenHttpException('没有权限修改！');
        }
    }
    
    /**
     * Update the avatar using the crop plugin and it is working on the cell phone too.
     * It is ajax function.
     * @param integer $id of the user
     */
    public function actionChangeAvatar($id)
    {
    	$model = $this->findModel($id);
    	
    	if (\Yii::$app->user->can('updateUser', ['user' => $model])) {
    		// update userself avatar
	    	$crop = new CropAvatar(
	    			isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null,
	    			isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null,
	    			isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null,
	    			$id
	    	);
	    	
	    	$response = array(
	    			'state'  => 200,
	    			'message' => $crop -> getMsg(),
	    			'result' => $crop -> getResult()
	    	);
	    	
	    	$model->scenario='UpdateAvatar';
	    	
	    	$model->face = '/'.$crop -> getResult();
	
	    	$model->save();
	    	
	//     	var_dump($response);
	    	
	//     	die();
	    	
	    	echo json_encode($response);
    	}
    	else {
    		throw new ForbiddenHttpException('没有权限修改！');
    	}
    }
    
}
