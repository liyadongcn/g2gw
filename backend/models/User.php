<?php
namespace backend\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use common\models\RelationshipsMap;
use common\models\AuthAssignment;


/**
 * 
 */
class User extends \common\models\User
{
   
    public $password_repeat;
    public $file;
    public $permissions;

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
        ]);
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

}
