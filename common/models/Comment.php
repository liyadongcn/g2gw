<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\Expression;
use common\models\User;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $model_type
 * @property integer $model_id
 * @property string $approved
 * @property integer $thumbsup
 * @property integer $thumbsdown
 * @property string $content
 * @property string $created_date
 * @property string $updated_date
 * @property integer $userid
 * @property string $author
 * @property string $author_ip
 */
class Comment extends \yii\db\ActiveRecord
{
// 	const COMMENT_STATUS_APPROVED='approved';//批准
// 	const COMMENT_STATUS_REFUSED='refused';//驳回
// 	const COMMENT_STATUS_SPAM='spam';//垃圾评论
// 	const COMMENT_STATUS_TRASH='trash';//移至回收站
	
	const MODEL_TYPE_GOODS='goods';
	const MODEL_TYPE_COMMENT='comment';
	const MODEL_TYPE_POST='posts';
	const MODEL_TYPE_BRAND='brand';
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * Auto setting the comment created date and updated date
     * 
     * @inheritdoc
     */
    public function behaviors()
    {
    	return [
    			[
    				'class' => TimestampBehavior::className(),
    				'createdAtAttribute' => 'created_date',
    				'updatedAtAttribute' => 'updated_date',
    				'value' => new Expression('NOW()'),
    			],
    			[
	    			'class' => BlameableBehavior::className(),
	    			'createdByAttribute' => 'userid',
	    			'updatedByAttribute' => false,
    			],
    	];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'model_id', 'thumbsup', 'thumbsdown', 'userid'], 'integer'],
        	[['parent_id'], 'default','value'=>0],
        	[['thumbsup', 'thumbsdown'], 'default','value'=>0],
            [['content'], 'string'],
        	[['content'], 'required'],
            [['created_date', 'updated_date'], 'safe'],
            [['model_type'], 'string', 'max' => 20],
            [['approved'], 'string', 'max' => 10],
        	[['approved'], 'default', 'value' => COMMENT_STATUS_APPROVED],
            [['author', 'author_ip'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'model_type' => 'Model Type',
            'model_id' => 'Model ID',
            'approved' => 'Approved',
            'thumbsup' => 'Thumbsup',
            'thumbsdown' => 'Thumbsdown',
            'content' => '评论内容',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'userid' => 'Userid',
            'author' => 'Author',
            'author_ip' => 'Author Ip',
        ];
    }
    
    
    /**
     * This function is to get all the sub comments list total count.
     *
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getSubCommentsCount()
    {
    	return self::find()->where(['parent_id'=>$this->id])->count();
    
    }
    
    /**
     * This function is to get all the sub comments list.
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getSubComments()
    {
    	return self::findAll(['parent_id'=>$this->id]);
    
    }
    
    /**
     * This function is to get the user object of this comments.
     *
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getUser()
    {
    	return $this->hasOne(User::className(),['id'=>'userid']);
    				//->where();
    	//self::find()->where(['parent_id'=>$this->id])->count();
    
    }
    
    /**
     * This function is to add one comment to the related to the model.
     * 用户对相应的数据模型发表一条评论
     *
     * @author Wintermelon
     * @since  1.0
     */
    /* public function addComment($model)
    {
    	if($this->validate())
    	{
    		$this->model_type=strtolower(StringHelper::basename($model->className()));
    		$this->model_id=$model->id;
    		if(yii::$app->user->isGuest)
    		{
    			//$this->userid=0;
    			$this->author='匿名用户';
    		}
    		else
    		{
    			//$this->userid=yii::$app->user->id;
    			$this->author=User::findIdentity(yii::$app->user->id)->displayName;
    		}
    		$author_ip= Yii::$app->request->userIP;
    		$author_ip===null?:$this->author_ip=$author_ip;
    		$this->save();
    		$model->updateCounters(['comment_count'=>1]);
    		//$this->content='';
    		return true;
    	}
    	return false;
    } */
    
    public function getStatus()
    {
    	return $this->approved;
    }
    
    public function beforeSave($insert)
    {
    	if (parent::beforeSave($insert)) {
    		// ...custom code here...
    		// Insert action 
    		if($insert){
    			// comment author name
    			$this->author=User::findIdentity(yii::$app->user->id)->displayName;
    			// comment from IP
    			$this->author_ip= Yii::$app->request->userIP;
    			// update commented model comment counts
    			$model=$this->getModel($this->model_type, $this->model_id);
    			//var_dump($model);
    			//die();
    			if($model){
    				$model->updateCounters(['comment_count'=>1]);
    			}
    		}    		
    		return true;
    	} else {
    		return false;
    	}
    }
    
    public function afterSave($insert,$changedAttributes)
    {
    	if (parent::afterSave($insert,$changedAttributes)) {
    		// ...custom code here...    		
    		return true;
    	} else {
    		return false;
    	}
    }
    
    public function getModel($modelType,$modelId)
    {
    	switch ($modelType){
    		case MODEL_TYPE_BRAND:
    			$model=Brand::findOne(['id'=>$modelId]);
    			break;
    		case MODEL_TYPE_GOODS:
    			$model=Goods::findOne(['id'=>$modelId]);
    			break;
    		case MODEL_TYPE_POSTS:
    			$model=Posts::findOne(['id'=>$modelId]);
    			break;
    		default:
    			return false;
    	}
    	return $model;
    }
}
