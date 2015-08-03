<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use backend\models\CommentSearch;
use backend\models\BrandSearch;
use backend\models\PostsSearch;
use backend\models\GoodsSearch;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_ONLINE =20;
    const DEFAULT_USER_FACE='uploads\user\default_small.png';
    
    const MODEL_TYPE_GOODS='goods';
    const MODEL_TYPE_COMMENT='comment';
    const MODEL_TYPE_POSTS='posts';
    const MODEL_TYPE_BRAND='brand';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED,self::STATUS_ONLINE]],
        	['face', 'default', 'value' =>self::DEFAULT_USER_FACE],
        	['onlineTime','default','value'=>0],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    /**
     * Get all the submitted comments of this user 
     */
    public function getComments()
    {
    	$searchModel=new CommentSearch();
    	$dataProvider = $searchModel->search(['CommentSearch'=>['userid'=>$this->id]]);
    	$dataProvider->pagination->pageSize=5;
    	
    	return $dataProvider;
    }

    /**
     * Get all the published posts of this user 
     */
    public function getPosts()
    {
        $searchModel=new PostsSearch();
        $dataProvider = $searchModel->search(['PostsSearch'=>['userid'=>$this->id]]);
        $dataProvider->pagination->pageSize=6;
        
        return $dataProvider;
    }
    
    public function getRelationshipModels($relationship,$model_type)
    {
//     	$relationshipsMaps=$this->getRelationshipsMaps()->where(['relationship_id'=>$relationship,'model_type'=>$model_type])->all();
//     	//var_dump($relationshipsMaps);
//     	//die();
//     	if($relationshipsMaps)
//     	{
    	
//     		foreach ($relationshipsMaps as $relationshipsMap)
//     		{
//     			$models[]=$relationshipsMap->getModel();
//     		}
//     		return $models;
//     	}
    	
    	switch ($model_type)
    	{
    		case self::MODEL_TYPE_BRAND:
    			$searchModel = new BrandSearch();
    			$dataProvider = $searchModel->search(['BrandSearch'=>['relationship'=>$relationship,'userid'=>$this->id]]);
    			break;
    		case self::MODEL_TYPE_GOODS:
    			$searchModel = new GoodsSearch();
    			$dataProvider = $searchModel->search(['GoodsSearch'=>['relationship'=>$relationship,'userid'=>$this->id]]);
    			break;
    		case self::MODEL_TYPE_POSTS:
    			$searchModel = new PostsSearch();
    			$dataProvider = $searchModel->search(['PostsSearch'=>['relationship'=>$relationship,'relationship_userid'=>$this->id]]);
    			break;
    		default:
    			return null;
    	}
    	return $dataProvider;
    }
    

    /**
     * This function is to get all the relationship map records of this user.
     * 得到用户所有的关系映射记录
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getRelationshipsMaps()
    {
    	return $this->hasMany(RelationshipsMap::className(), ['userid'=>'id']);
    	//->where(['model_type'=>$this->modelType()]);
    	//->all();
    }
    
    
    
}
