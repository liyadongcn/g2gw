<?php
namespace frontend\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use common\models\RelationshipsMap;
use common\models\AuthAssignment;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\swiftmailer\Message;


/**
 * 
 */
class User extends \common\models\User
{
	const USER_FACE_FILEPATH='uploads/user';
   
    public $password_repeat;
    public $original_password;
    //public $file;//Uploaded avatar.
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return 
        array_merge(parent::rules(),
        [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'message' => '用户名已经被使用,请重新填写'],
            ['username', 'string', 'min' => 2, 'max' => 30],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'message' => '邮箱已经使用,请更换邮箱'],

            ['password', 'required','message'=>'密码不能为空'],
            ['password', 'string', 'min' => 6,'message'=>'密码至少有6个数字或字母组成'],

            ['password_repeat', 'required','message'=>'重复密码不能为空'],
            ['password_repeat', 'string', 'min' => 6,'message'=>'密码至少有6个数字或字母组成'],
        		
        	['original_password', 'required','on'=>'UpdatePassword','message'=>'必须填写原密码'],        	
        	['original_password', 'validateOriginalPassword','on'=>'UpdatePassword'],
            // built-in "compare" validator
            //['password', 'compare', 'compareAttribute' => 'password2'],
            ['password','compare','message'=>'重复密码必须与密码一致'],

            ['cellphone','string','max'=>11],

            ['cellphone','match','pattern'=>'/\d{11}/','message'=>'请填写11位正确的手机号码'],

        	['nickname', 'safe'],
        	
        	
        ]);
    }
    
    public function validateOriginalPassword()
    {
    	if (!$this->validatePassword($this->original_password)) {
    		//var_dump($this);
    		//die();
    		$this->addError('original_password','原密码错误');
    	}
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
    	return [
    			'original_password' => '原始密码',
    			'email' => '邮箱',
    			'nickname' => '昵称',
    			'cellphone' => '手机',
    	];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
    	return [
    			//'login' => ['username', 'password'],
    			'UpdateAvatar' => ['face'],
    			'UpdateProfile' => ['email', 'nickname','cellphone'],
    			'UpdatePassword' => ['original_password','password','password_repeat'],
    	];
    }
    

}
