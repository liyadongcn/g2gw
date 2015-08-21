<?php
namespace backend\models;

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


/**
 * 
 */
class User extends \common\models\User
{
	const USER_FACE_FILEPATH='uploads/user';
   
    public $password_repeat;
    public $file;//Uploaded avatar.
    public $permissions;
    public $crop_info;//Crop information for the avatar image.
    
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
            ['username', 'unique', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 30],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['password_repeat', 'required'],
            ['password_repeat', 'string', 'min' => 6],

            // built-in "compare" validator
            //['password', 'compare', 'compareAttribute' => 'password2'],
            ['password','compare'],

            ['cellphone','string','max'=>11],

            ['cellphone','match','pattern'=>'/\d{11}/'],

            [['file'], 'file'],
        	
        	[['permissions'], 'safe'],
        	
        	['crop_info', 'safe'],
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
    	return [
    			//'login' => ['username', 'password'],
    			'UpdateAvatar' => ['file', 'crop_info','face'],
    	];
    }
    
    /**
     * This function is to get the all relationshipsmap records of the user.
     *
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getRelationshipsMaps()
    {
    	return $this->hasMany(RelationshipsMap::className(), ['userid'=>'id']);
    	//->where(['model_type'=>$this->modelType(),'parent_id'=>0]);
    	//->all();
    }

      /**
     * This function is to get the all auth_assignments of the user.
     *
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['user_id'=>'id']);
        //->where(['model_type'=>$this->modelType(),'parent_id'=>0]);
        //->all();
    }
    
    /**
     * This function is to get the all auth_assignments of the user.
     *
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function setAuthAssignments()
    {
    	//Compare the difference of the permissions to get the deleted auth;
    	$oldPermissions = ArrayHelper::map($this->authAssignments,'item_name','item_name');
    	if($this->permissions)
    	{
    		$deletedPermissions = array_diff($oldPermissions, $this->permissions);
    	}
    	
    	else
    	{
    		$deletedPermissions = array_diff($oldPermissions, []);
    	}
    	if(!empty($deletedPermissions)){
    		AuthAssignment::deleteAll(['item_name'=>$deletedPermissions,'user_id'=>$this->id]);
    	}
        if($this->permissions)
 		{
           foreach ($this->permissions as $permission) {
               $authAssignment=new AuthAssignment();
               $authAssignment->item_name=$permission;
               $authAssignment->user_id=$this->id;
               $authAssignment->save();
           }
       	}
    }
    
    /**
     * Finds authassignment by item_name
     *
     * @param string $item_name
     * @return AuthAssignment|null
     */
    public function findAuthAssignmentByItemName($itemName)
    {
    	return AuthAssignment::findOne(['item_name' => $itemName, 'user_id' => $this->id]);
    }
    
    public function beforeSave($insert)
    {
     	if (parent::beforeSave($insert)) {
              // ...custom code here...
     		if(!$this->file) return true;
     		// open image
     		$image = Image::getImagine()->open($this->file->tempName);
     		
     		// rendering information about crop of ONE option
     		$cropInfo = Json::decode($this->crop_info)[0];
     		$cropInfo['dWidth'] = (int)$cropInfo['dWidth']; //new width image
     		$cropInfo['dHeight'] = (int)$cropInfo['dHeight']; //new height image
     		$cropInfo['x'] = $cropInfo['x']; //begin position of frame crop by X
     		$cropInfo['y'] = $cropInfo['y']; //begin position of frame crop by Y
     		// Properties bolow we don't use in this example
     		//$cropInfo['ratio'] = $cropInfo['ratio'] == 0 ? 1.0 : (float)$cropInfo['ratio']; //ratio image.
     		//$cropInfo['width'] = (int)$cropInfo['width']; //width of cropped image
     		//$cropInfo['height'] = (int)$cropInfo['height']; //height of cropped image
     		//$cropInfo['sWidth'] = (int)$cropInfo['sWidth']; //width of source image
     		//$cropInfo['sHeight'] = (int)$cropInfo['sHeight']; //height of source image
     		
     		//delete old images
     		$oldImages = FileHelper::findFiles(self::USER_FACE_FILEPATH, [
     		'only' => [
     		$this->id . '.*',
     		'thumb_' . $this->id . '.*',
     		],
     		]);
     		for ($i = 0; $i != count($oldImages); $i++) {
     			@unlink($oldImages[$i]);
     		}
     		
     		//saving thumbnail
     		$newSizeThumb = new Box($cropInfo['dWidth'], $cropInfo['dHeight']);
     		$cropSizeThumb = new Box(100, 100); //frame size of crop
     		$cropPointThumb = new Point($cropInfo['x'], $cropInfo['y']);
     		$pathThumbImage = self::USER_FACE_FILEPATH
     		. '/thumb_'
     				. $this->id
     				. '.'
     						. $this->file->getExtension();
     		
     		$image->resize($newSizeThumb)
     		->crop($cropPointThumb, $cropSizeThumb)
     		->save($pathThumbImage, ['quality' => 100]);
     		 
     		$this->face = $pathThumbImage;
     		
     		//saving original
     		$this->file->saveAs(
     				self::USER_FACE_FILEPATH
     				. '/'
     				. $this->id
     				. '.'
     				. $this->file->getExtension()
     		);
              return true;
         } else {
              return false;
         }
	
    }
    

}
