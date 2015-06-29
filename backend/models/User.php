<?php
namespace backend\models;

use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
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
