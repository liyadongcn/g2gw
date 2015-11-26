<?php

namespace backend\controllers;

use Yii;
use common\models\Brand;
use common\models\Comment;
use common\models\Ecommerce;
use common\models\Category;
use common\models\base\Model;
use backend\models\BrandSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * BrandController implements the CRUD actions for Brand model.
 */
class BrandController extends Controller
{
	const UPLOAD_FILE_PATH='uploads\\brand\\logo\\';
	
	const SHOW_STYLE_LIST=0;
	
	const SHOW_STYLE_GRID=1;
	
	public function init(){
		
	}
		
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
    	if(yii::$app->user->can('createBrand')){
    	
        $model = new Brand;
        $modelEcommerces = [new Ecommerce()];

        if ($model->load(Yii::$app->request->post())) {

            $modelEcommerces = Model::createMultiple(Ecommerce::classname());
            Model::loadMultiple($modelEcommerces, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelEcommerces),
                    ActiveForm::validate($model)
                );
            }

             //Get the uploaded file instance
            $model->file = UploadedFile::getInstance($model, 'file');
            
            if ($model->file ) {
                $model->file->saveAs(self::UPLOAD_FILE_PATH . $model->en_name. '.' . $model->file->extension);
                $model->logo=self::UPLOAD_FILE_PATH. $model->en_name. '.' . $model->file->extension;
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelEcommerces) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelEcommerces as $modelEcommerce) {
                            $modelEcommerce->brand_id = $model->id;
                            if (! ($flag = $modelEcommerce->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        //set the categories of this model.
                        $model->setCategories();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'modelEcommerces' => (empty($modelEcommerces)) ? [new Ecommerce] : $modelEcommerces
        ]);
    	}
    	else{
    		throw new ForbiddenHttpException('You are not allow to create a new brand!');
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
        //var_dump($model->getCategories()->all());
        //die();
        $model->categories=ArrayHelper::map($model->getCategories()->all(), 'name','id');
        //var_dump($model->categories);
        $modelEcommerces = $model->ecommerces;

        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelEcommerces, 'id', 'id');
            $modelEcommerces = Model::createMultiple(Ecommerce::classname(), $modelEcommerces);
            Model::loadMultiple($modelEcommerces, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelEcommerces, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelEcommerces),
                    ActiveForm::validate($model)
                );
            }

            //Get the uploaded file instance
            $model->file = UploadedFile::getInstance($model, 'file');
            
            if ($model->file && $model->validate()) {
                $model->file->saveAs(self::UPLOAD_FILE_PATH . $model->en_name. '.' . $model->file->extension);
                $model->logo=self::UPLOAD_FILE_PATH. $model->en_name. '.' . $model->file->extension;
            }

            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelEcommerces) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            Ecommerce::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelEcommerces as $modelEcommerce) {
                            $modelEcommerce->brand_id = $model->id;
                            if (! ($flag = $modelEcommerce->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
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
            'modelEcommerces' => (empty($modelEcommerces)) ? [new Ecommerce] : $modelEcommerces
        ]);
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
    
    	return $this->render('results', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			'showStyle' =>$this->showStyle,
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
    
    	return $this->render('results', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			'showStyle' =>$this->showStyle,
    	]);
    }
    
    /**
     * Search the models with the same country code.
     *
     * @param integer $tagid
     * @return mixed
     */
    public function actionSearchByCountry($country_code)
    {
    	$searchModel = new BrandSearch();
    	$searchModel->country_code=$country_code;
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    	return $this->render('results', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			'showStyle' =>$this->showStyle,
    	]);
    }
    
    /**
     * Search the models with keyWords.
     *
     * 
     * @return mixed
     */
    public function actionSearchByKeyWords()
    {
    	$searchModel = new BrandSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    	return $this->render('results', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			'showStyle' =>$this->showStyle,
    	]);
    }
    
    /**
     * Change the results show style.
     *
     *
     * @return mixed
     */
    public function actionChangeShowStyle()
    {
    	if ($this->showStyle===self::SHOW_STYLE_LIST){
    		$this->showStyle=self::SHOW_STYLE_GRID;
    	}else{
    		$this->showStyle=self::SHOW_STYLE_LIST;    	
    	}
    
    	return $this->redirect(Yii::$app->request->referrer);
    }
    
    /**
     * Set show style.
     *
     *
     * @return mixed
     */
    public function setShowStyle($showStyle)
    {
    	$session=yii::$app->session->set('SHOW_STYLE',$showStyle);
    }
    
    /**
     * Get show style.
     *
     *
     * @return mixed
     */
    public function getShowStyle()
    {
    	return yii::$app->session->get('SHOW_STYLE',self::SHOW_STYLE_LIST);
    }
}
