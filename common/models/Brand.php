<?php

namespace common\models;

use Yii;
use common\models\Comment;
use common\models\Tag;
use common\models\Tagmap;
use common\models\Country;
use common\models\Company;
use backend\models\PostsSearch;
use yii\helpers\StringHelper;
use yii\helpers\ArrayHelper;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "brand".
 *
 * @property integer $id
 * @property string $en_name
 * @property string $country_code
 * @property string $logo
 * @property string $cn_name
 * @property string $introduction
 * @property string $baidubaike
 * @property integer $thumbsup
 * @property integer $thumbsdown
 * @property integer $company_id
 * @property integer $comment_count
 * @property integer $view_count
 */
class Brand extends base\ActiveRecord
{
	public $file;
	
	
	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();
		
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return 
        array_merge(parent::rules(),
        [
            [['introduction'], 'string'],
            [['thumbsup', 'thumbsdown', 'company_id', 'comment_count', 'view_count','star_count'], 'integer'],
        	[['thumbsup', 'thumbsdown', 'comment_count', 'view_count','star_count'], 'default','value'=>0],
            [['en_name', 'cn_name'], 'string', 'max' => 30],
            [['country_code'], 'string', 'max' => 3],
            [['logo', 'baidubaike'], 'string', 'max' => 255],
        	//[['tag_string'], 'string'],
        	[['file'], 'file']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'en_name' => 'En Name',
            'country_code' => 'Country Code',
            'logo' => 'Logo',
            'cn_name' => 'Cn Name',
            'introduction' => 'Introduction',
            'baidubaike' => 'Baidubaike',
            'thumbsup' => '点赞',
            'thumbsdown' => 'Thumbsdown',
            'company_id' => 'Company ID',
            'comment_count' => '评论',
            'view_count' => '浏览',
        	'star_count' => '收藏',
        	'file' => '品牌logo',
        	'tag_string'=>'标签',
        	'updated_date'=>'最新',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function modelType()
    {
    	return 'brand';
    }

    /**
     * This function is to get the all ecommerces of this brand.
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getEcommerces()
    {
    	return $this->hasMany(Ecommerce::className(), ['brand_id'=>'id']);
    	//->where(['model_type'=>$this->modelType(),'parent_id'=>0]);
    	//->all();
    }

    /**
     * This function is to get the company of this brand.
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getCompany()
    {
    	return $this->hasOne(Company::className(), ['id'=>'company_id']);
    	//->where(['model_type'=>$this->modelType(),'parent_id'=>0]);
    	//->all();
    }
    
    /**
     * This function is to get the country of this brand.
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getCountry()
    {
    	return $this->hasOne(Country::className(), ['code'=>'country_code']);
    	//->where(['model_type'=>$this->modelType(),'parent_id'=>0]);
    	//->all();
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
//     public static function getDropDownListData($field)
//     {
//     	switch ($field)
//     	{
//     		case 'country_code':
//     			return ArrayHelper::map(Country::find()->all(),'code','cn_name');
//     		case 'company_id':
//     			return ArrayHelper::map(Company::find()->all(),'id','name');
//     		//put more fields need to be mapped.
    			
//     		default:
//     			return [];
//     	}
//     }
    
    /**
     * This function is to get the related brands of this brand.
     * 
     * @param integer the number of the records needed. the default is 10.
     * @return array|null the model objects
     * 
     * @author Wintermelon
     * @since  1.0
     */
    public function getRelatedBrands($n=10)
    {
    	$query=$this->find();
    	$query->orFilterWhere(['like','country_code',$this->country_code])
    		  ->orFilterWhere(['=','company_id',$this->company_id])
    		  ->andFilterWhere(['!=','id',$this->id])
    		  ->orderBy(['view_count' => SORT_DESC, 'thumbsup' => SORT_DESC])
    		  ->limit($n);
    	return $query;    	
    }
    

    /**
     * This function is to get the hotest of this brand.
     *
     * @param integer the number of the records needed. the default is 10.
     * @return array|null the model objects
     * 
     * @author Wintermelon
     * @since  1.0
     */
    public static function getHotestBrands($n=10)
    {
    	$query=self::find();
    	$query->orderBy(['view_count' => SORT_DESC, 'thumbsup' => SORT_DESC])
    		  ->limit($n);
    	return $query;    
    	 
    }
    
    /**
     * This function is to get the latest of this brand(updated).
     *
     * @param integer the number of the records needed. the default is 10.
     * @return array|null the model objects
     *
     * @author Wintermelon
     * @since  1.0
     */
    public static function getLatestBrands($n=10)
    {
    	$query=self::find();
    	$query->orderBy(['updated_date' => SORT_DESC])
    	->limit($n);
    	return $query;
    
    }

    /**
     * @inheritdoc
     */
    public function delete()
    {
        try
        {
            
            Ecommerce::deleteAll(['brand_id'=>$this->id]);
           
        }
        catch (\Exception $e)
        {
            throw $e;
        }
        
        parent::delete();
    }
}
