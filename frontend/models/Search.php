<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Brand;
use backend\models\PostsSearch;
use backend\models\GoodsSearch;
use backend\models\BrandSearch;

/**
 * BrandSearch represents the model behind the search form about `common\models\Brand`.
 */
class Search extends Model
{
	const MODEL_TYPE_BRAND='brand';
	const MODEL_TYPE_GOODS='goods';
	const MODEL_TYPE_POSTS='posts';
	
	public $keyWords;
	public $model_type;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	['keyWords','safe'],
        	['model_type','default','value'=>self::MODEL_TYPE_BRAND],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
    	$this->load($params);
    	
    	if(!$this->validate())
    	{
    		return null;
    	}
    	//Save the serach model type to the session.
    	//This will tell the main layout the current search model type and reset the selection input for searching.
    	$session=yii::$app->session->set('SEARCH_MODEL_TYPE',$this->model_type);
    	
    	switch ($this->model_type)
    	{
    		case self::MODEL_TYPE_BRAND:
    			$searchModel = new BrandSearch();
    			break;
    		case self::MODEL_TYPE_GOODS:
    			$searchModel = new GoodsSearch();
    			break;
    		case self::MODEL_TYPE_POSTS:
    			$searchModel = new PostsSearch();
    			break;
    		default:
    			return null;
    	}
    	$searchModel->keyWords=$this->keyWords;
    	//var_dump($params);
    	//die();
    	return $dataProvider = $searchModel->search($params);

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
//     		case 'model_type':
//     			return ArrayHelper::map(Brand::find()->all(),'id','en_name');
    		case 'model_type':
    			return [
    			self::MODEL_TYPE_BRAND=>'品牌',
    			self::MODEL_TYPE_GOODS=>'商品',
    			self::MODEL_TYPE_POSTS=>'发帖'
    					];
    					//put more fields need to be mapped.
    			
    		default:
    			return [];
    	}
    }
}
