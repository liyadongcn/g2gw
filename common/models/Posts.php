<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use common\models\User;


/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $post_title
 * @property string $post_content
 * @property string $post_type
 * @property string $post_status
 * @property string $url
 * @property string $created_date
 * @property string $updated_date
 * @property integer $userid
 * @property integer $comment_count
 * @property integer $thumbsup
 * @property integer $thumbsdown
 * @property string $effective_date
 * @property string $expired_date
 * @property integer $view_count
 */
class Posts extends base\ActiveRecord
{
	const POST_TYPE_PROMOTION='promotion';
	const POST_TYPE_ARTICLE='article';
	const POST_TYPE_OTHER='other';
	
	const POST_STATUS_PUBLISH='publish';
	const POST_STATUS_DRAFT='draft';
	
	/**
	 * @var UploadedFiles|Null file attribute
	 */
	public $file;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return 
        array_merge(parent::rules(),
        [
            [['post_content'], 'string'],
            [['created_date', 'updated_date', 'effective_date', 'expired_date'], 'safe'],
            [['userid', 'comment_count', 'thumbsup', 'thumbsdown', 'view_count', 'star_count'], 'integer'],
            [['post_title', 'url'], 'string', 'max' => 100],
            [['post_type', 'post_status'], 'string', 'max' => 20],
        	[['post_type'], 'default', 'value' => self::POST_TYPE_OTHER],
        	[['post_status'], 'default', 'value' => self::POST_STATUS_PUBLISH],
        	[['comment_count', 'thumbsup', 'thumbsdown', 'view_count', 'star_count'], 'default','value'=>0],
        	
        ]
        );
    }


    
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_title' => 'Post Title',
            'post_content' => 'Post Content',
            'post_type' => 'Post Type',
            'post_status' => 'Post Status',
            'url' => 'Url',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'userid' => 'Userid',
            'comment_count' => 'Comment Count',
            'thumbsup' => 'Thumbsup',
            'thumbsdown' => 'Thumbsdown',
            'effective_date' => 'Effective Date',
            'expired_date' => 'Expired Date',
            'view_count' => 'View Count',
            'star_count' => 'Star Count', 
        ];
    }
    
    /**
     * This function is   to get the dropdownlist data for the field in this model.
     *
     * @param  string      $field   the field name.
     * @return array|null           the maping data for the dropdwonlist.
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getDropDownListData($field)
    {
    	switch ($field)
    	{
    		case 'post_status':
    			return [
    				Posts::POST_STATUS_PUBLISH=>'直接发布',
    				Posts::POST_STATUS_DRAFT=>'保存为草稿',    				
    		];
    		case 'post_type':
    			return [
    				Posts::POST_TYPE_ARTICLE=>'文章',
    				Posts::POST_TYPE_PROMOTION=>'促销活动',
    				Posts::POST_TYPE_OTHER=>'其他',
    		];
    			//put more fields need to be mapped.
    			
    		default:
    			return [];
    	}
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
     * This function is to get the related of this brand.
     *
     * @param integer $n the number of the records needed. the default is 10.
     * @return array|null the model objects
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getRelatedPosts($n=10)
    {
    	 $query=$this->find();
    	
    	$query->orFilterWhere(['=','userid',$this->userid])
    	      ->andFilterWhere(['!=','id',$this->id])
    		  ->orderBy(['view_count' => SORT_DESC, 'thumbsup' => SORT_DESC])
    		  ->limit($n);
    	return $query; 
    	 
    }
    
    /**
     * This function is to get the hotest of this brand.
     *
     * @param integer $n the number of the records needed. the default is 10.
     * @return array|null the model objects
     *
     * @author Wintermelon
     * @since  1.0
     */
    public static function getHotestPosts($n=10)
    {
    	$query=self::find();
    	
    	$query->orderBy(['view_count' => SORT_DESC, 'thumbsup' => SORT_DESC,'updated_date' =>SORT_DESC])
    		  ->limit($n);
    	return $query;   
    
    }
    
    /**
     * This function is to get the latest of this post(updated).
     *
     * @param integer the number of the records needed. the default is 10.
     * @return array|null the model objects
     *
     * @author Wintermelon
     * @since  1.0
     */
    public static function getLatestPosts($n=10)
    {
    	$query=self::find();
    	$query->orderBy(['updated_date' => SORT_DESC])
    	->limit($n);
    	return $query;
    
    }
}
