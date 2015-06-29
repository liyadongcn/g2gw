<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use common\models\Album;
use common\models\Category;
use common\models\CategoryMap;
use common\models\Pricehistory;


/**
 * This is the model class for table "goods".
 *
 * @property string $id
 * @property string $brand_id
 * @property string $code
 * @property string $description
 * @property integer $thumbsup
 * @property integer $thumbsdown
 * @property string $url
 * @property string $title
 * @property string $comment_status
 * @property integer $comment_count
 * @property string $created_date
 * @property string $updated_date
 * @property integer $interested_count
 * @property integer $recomended_count
 * @property integer $view_count
 */
class Goods extends base\ActiveRecord
{
	const STATUS_DELETED = 0;
	const STATUS_ACTIVE = 1;
	const COMMENT_STATUS_OPEN='open';
	const COMMENT_STATUS_CLOSE='close';
		
	/**
	 * @var UploadedFiles|Null file attribute
	 */
	public $file;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Goods';
    }
    


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return 
        array_merge(parent::rules(),
        [
            [['brand_id'], 'required'],
            [[ 'brand_id', 'thumbsup', 'thumbsdown', 'comment_count', 'star_count', 'recomended_count', 'view_count','status'], 'integer'],
            [['description'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['code'], 'string', 'max' => 30],
            [['url', 'title'], 'string', 'max' => 255],
            [['comment_status'], 'string', 'max' => 20],
        	[['comment_status'], 'default', 'value' =>self::COMMENT_STATUS_OPEN],
        	[['status'], 'default', 'value' =>self::STATUS_ACTIVE],
        	[['file'], 'file', 'maxFiles' => 6],        	
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand ID',
            'code' => 'Code',
            'description' => 'Description',
            'thumbsup' => 'Thumbsup',
            'thumbsdown' => 'Thumbsdown',
            'url' => 'Url',
            'title' => 'Title',
            'comment_status' => 'Comment Status',
            'comment_count' => 'Comment Count',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'star_count' => 'Star Count',
            'recomended_count' => 'Recomended Count',
            'view_count' => 'View Count',
        	'file' => '上传图片',
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
			case 'brand_id':
				return ArrayHelper::map(Brand::find()->all(),'id','en_name');
			case 'comment_status':
				return [
					self::COMMENT_STATUS_CLOSE=>'禁止评论',
					self::COMMENT_STATUS_OPEN=>'允许评论'
				];
			//put more fields need to be mapped.
			
			default:
				return [];
		}
    }
    
 
    
    public function getBrand()
    {
    
    	return $this->hasOne(Brand::className(),['id'=>'brand_id']);
    
    }
    
    public function getPricehistory()
    {
    
    	return $this->hasMany(Pricehistory::className(),['goods_id'=>'id']);
    
    }
    
    /**
     * This function is to get the related of this goods.
     *
     * @param integer the number of the records needed. the default is 10.
     * @return array|null the model objects
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getRelatedGoods($n=10)
    {
    	$query=$this->find();
    	
    	//$cateGories=$this->getCategories();
    	
    	//var_dump($cateGories);
    	//die();
    	
//     	if($cateGories)
//     	{
    		
//     		foreach ($cateGories as $category)
//     		{
//     			$query->orFilterWhere(['like','title',$category->name]);
//     		}
//     	}
    	
    	$query->andFilterWhere(['!=','id',$this->id])
    	      ->andFilterWhere(['=','brand_id',$this->brand_id])
    		  ->orderBy(['view_count' => SORT_DESC, 'thumbsup' => SORT_DESC])
    		  ->limit($n);
    	return $query;   
    	 
    }
    
    /**
     * This function is to get the hotest of this goods.
     *
     * @param integer the number of the records needed. the default is 10.
     * @return array|null the model objects
     *
     * @author Wintermelon
     * @since  1.0
     */
    public static function getHotestGoods($n=10)
    {
    	$query=self::find();
    	
    	$query->orderBy(['view_count' => SORT_DESC, 'thumbsup' => SORT_DESC,'updated_date' =>SORT_DESC])
    		  ->limit($n);
    	return $query;   
    
    }
    
    /**
     * This function is to get the latest of this goods(updated).
     *
     * @param integer the number of the records needed. the default is 10.
     * @return array|null the model objects
     *
     * @author Wintermelon
     * @since  1.0
     */
    public static function getLatestGoods($n=10)
    {
    	$query=self::find();
    	$query->orderBy(['updated_date' => SORT_DESC])
    	->limit($n);
    	return $query;
    
    }

}