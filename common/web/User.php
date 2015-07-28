<?php
namespace common\web;

use yii;
use yii\helpers\VarDumper;

class User extends \yii\web\User
{
	

    function init()
    {
    	parent::init();
    	$this->on(self::EVENT_AFTER_LOGIN, [$this,'afterUserLogin']);
    	$this->on(self::EVENT_BEFORE_LOGOUT, [$this,'beforeUserLogout']);
    }
    
    static  function afterUserLogin($event)
    {
    	
    	
    	$cookies = Yii::$app->request->cookies;
    	
    	$cookies->readOnly=false;
    	
    	$lastLoginTime = $cookies->getValue('lastLoginTime', '');
    	
    	//var_dump($cookies);
    	
    	//echo $lastLoginTime;
    	
    	$session = Yii::$app->session;
    	
    	$session->set('lastLoginTime', $lastLoginTime);
    	
    	$loginTime=date('Y-m-d H:i:s',time());
    	
    	$session->set('loginTime',$loginTime);
    	
    	$cookiesResponse = Yii::$app->response->cookies;
    	
    	$cookiesResponse->add(new \yii\web\Cookie([
    			'name' => 'lastLoginTime',
    			'value' => $loginTime,
    	]));
    	
    	//$user=\common\models\User::findIdentity(Yii::$app->user->id);
    	
    	//$user->status=\common\models\User::STATUS_ONLINE;
    	
    	//$user->save();
    	
    }
    
    static  function beforeUserLogout($event)
    {
    	$user=\common\models\User::findIdentity(Yii::$app->user->id);
    	 
    	//$user->status=\common\models\User::STATUS_ACTIVE;
    	 
    	$session = Yii::$app->session;
    	
    	$loginTime=$session->get('loginTime');
    	
    	$user->onlineTime=$user->onlineTime+time()-strtotime($loginTime);
    	
    	$user->save();
    }
}