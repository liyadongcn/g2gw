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
	const POST_TYPE_PROMOTION=37;
	const POST_TYPE_ARTICLE=38;
//	const POST_TYPE_OTHER='other';
	

	
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
            [['userid', 'brand_id','comment_count', 'thumbsup', 'thumbsdown', 'view_count', 'star_count'], 'integer'],
            [['post_title', 'url'], 'string', 'max' => 100],
            [['post_status'], 'string', 'max' => 20],
        	[['post_status'], 'default', 'value' => POST_STATUS_PUBLISH],
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
            'post_title' => '标题',
            'post_content' => '内容',
            'post_status' => '发布状态',
            'url' => 'Url网址',
            'created_date' => 'Created Date',
            'updated_date' => '最新',
            'userid' => 'Userid',
            'comment_count' => '评论',
            'thumbsup' => '口碑',
            'thumbsdown' => 'Thumbsdown',
            'effective_date' => '活动开始时间',
            'expired_date' => '活动结束时间',
            'view_count' => '浏览',
            'star_count' => '收藏', 
        	'brand_id' =>'涉及品牌',
            'file'=>'上传图片',
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
//     public function getDropDownListData($field)
//     {
//     	switch ($field)
//     	{
//     		case 'post_status':
//     			return [
//     				Posts::POST_STATUS_PUBLISH=>'直接发布',
//     				Posts::POST_STATUS_DRAFT=>'保存为草稿',    				
//     		];
// //     		case 'post_type':
// //     			return [
// //     				Posts::POST_TYPE_ARTICLE=>'文章',
// //     				Posts::POST_TYPE_PROMOTION=>'促销活动',
// //     				Posts::POST_TYPE_OTHER=>'其他',
// //     		];
//     			//put more fields need to be mapped.
    			
//     		default:
//     			return [];
//     	}
//     }
    
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
//     public function getRelatedPosts($n=10)
//     {
//     	 $query=$this->find();
    	
//     	$query->andFilterWhere(['!=','id',$this->id])
//     		  ->orderBy(['view_count' => SORT_DESC, 'thumbsup' => SORT_DESC])
//     		  ->limit($n);
//     	return $query; 
    	 
//     }
    
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
    
    /**
     * This function is to get the latest promotions.
     *
     * @param integer the number of the records needed. the default is 5.
     * @return array|null the model objects
     *
     * @author Wintermelon
     * @since  1.0
     */
    public static function getPromotions($n=5)
    {
//     	return $this->hasMany(Posts::className(),['id'=>'model_id'])
//     	->viaTable('category_map',['model_type'=>MODEL_TYPE_POSTS,'category_id'=>self::POST_TYPE_PROMOTION])
//     	->orderBy(['updated_date' => SORT_DESC])
//     	->limit($n);
    	//$categoryMaps=CategoryMap::find()->where(['model_type'=>MODEL_TYPE_POSTS,'category_id'=>self::POST_TYPE_PROMOTION]);
    	$query=self::find()
    	->joinWith('categoryMap')->where(['model_type'=>MODEL_TYPE_POSTS,'category_id'=>self::POST_TYPE_PROMOTION]);
    	$query->orderBy(['updated_date' => SORT_DESC])
    	->limit($n);
     	//var_dump($query->all());
     	//die();
    	return $query;
    
    }
    
    /**
     * This function is to get the brand of this post concerning.
     *
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getBrand()
    {
    	return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    	//->where();
    	//self::find()->where(['parent_id'=>$this->id])->count();
    
    }
}
