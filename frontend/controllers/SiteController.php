<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\CommentForm;
use frontend\models\Search;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use SolrClient;
use SolrQuery;
use SolrInputDocument;
use common\models\solr\SolrDataProvider;
use common\models\solr\common\models\solr;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','contact'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                	[
                		'actions' => ['contact'],
                		'allow' => true,
                		'roles' => ['@'],
                	],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
    	$searchModel = new Search();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	
    	return $this->render('index', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    	//return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return $this->redirect(Yii::$app->user->returnUrl);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
            $model = new ContactForm();
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                    Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                } else {
                    Yii::$app->session->setFlash('error', 'There was an error sending email.');
                }

                return $this->refresh();
            } else {
                $user= User::findIdentity(Yii::$app->user->id);
                $model->name=$user->username;
                $model->email=$user->email;
                return $this->render('contact', [
                    'model' => $model,
                ]);
            }
      }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            //Get the uploaded file instance
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file) {                
                $model->file->saveAs('uploads\\' . $model->username. '.' . $model->file->extension);
            }
            
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    // return $this->goHome();
                    $returnUrl = Yii::$app->user->returnUrl;
                    return $this->redirect($returnUrl);
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    public function actionComment()
    {
    	
    	// $model = new CommentForm();
    	// if ($model->load(Yii::$app->request->post()) && $model->saveComment()) {
    	// 	return $this->goHome();
    	// } else {
    	// 	return $this->render('comment', [
    	// 			'model' => $model,
    	// 			]);
    	// }
		//echo solr_get_version();
		$options = array
		(
		    'hostname' => SOLR_SERVER_HOSTNAME,
		    'login'    => SOLR_SERVER_USERNAME,
		    'password' => SOLR_SERVER_PASSWORD,
		    'port'     => SOLR_SERVER_PORT,
			'path'     => SOLR_SERVER_PATH,
			'wt'       => 'json',
		
		);
				
		$client = new SolrClient($options);
		
		$query = new SolrQuery();
		
		$query->setQuery('*:*');
		
		$query->addField('id');
		
		//$query->addField('tstamp');
		
		//$query->addField('title');
		
		//$query->addField('content');

		//$query->addField('url');
		
// 		$query->addField('id')->addField('title');
		
// 		$query->setStart(0);
		
// 		$query->setRows(10);
		
		$dataProvider=new SolrDataProvider([
				'solr' => $client,
				'query' => $query,
				'pagination' => [
        				'pagesize' => '5',
        		],
				'sort' => [
						'defaultOrder' => [
								'id' => SolrQuery::ORDER_DESC,
						]
				],
		]);
		
// 		$dataProvider->solr=$client;
		
// 		$dataProvider->query=$query;
		
		//$dataProvider->pagination->pagesize=5;
		
		//var_dump($dataProvider);
		
// 		echo $query;
		
// 		die();
		
		return $this->render('solr_response',['dataProvider'=>$dataProvider]);
		
		/* $models=$dataProvider->models;
		
		echo $dataProvider->getTotalCount();
		
		foreach ($models as $doc)
		{
			echo "id:".$doc->id."</br>";
			echo "titles:"."</br>";
			foreach ($doc->title as $title)
			{
				echo "&nbsp&nbsp".$title."</br>";
			}
		} */
		
		
		
/* 		$query_response = $client->query($query);
		
		$response = $query_response->getResponse();
		
		print_r($response);
		
		echo "////////////////////////////////////";
		
		var_dump($response['responseHeader']);
		
		foreach ($response->response->docs as $doc)
		{
			echo "id:".$doc->id."</br>";
			echo "titles:"."</br>";
			foreach ($doc->title as $title)
			{
				echo "&nbsp&nbsp".$title."</br>";
			}
				
		}
		 */

				
		}
}
