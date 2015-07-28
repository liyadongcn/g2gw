<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $parent_id
 * @property string $name
 * @property string $model_type 
 * @property integer $order 
 */
class Category extends \yii\db\ActiveRecord
{
	const MODEL_TYPE_GOODS='goods';
	const MODEL_TYPE_POSTS='posts';
	const MODEL_TYPE_BRAND='brand';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'order'], 'integer'],
            [['parent_id'], 'default','value'=>0], 
        	[['count'], 'default','value'=>0],
            [['name'], 'string', 'max' => 30],
        	[['name','model_type'], 'unique','targetAttribute' => ['name', 'model_type'],'message'=>'已经有该分类了'],
        	[['model_type'], 'string', 'max' => 20]
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
            'name' => 'Name',
        	'model_type' => 'Model Type',
        	'order' => 'Order',
        ];
    }
    
    /**
     * This function will return the catagory model name by the classified name
     * Displayed model name will look like
     * Cloth
     *     man
     *     woman
     *     child
     * Electronic
     *     cell
     *     TV
     *     Computer
     * 			laptop computer
     * 			desktop computer
     * 。。。。
     * 。。。。
     * @param  integer $pid the parent category id
     * @return array   $result the category name already be formatted.
     * @author Wintermelon
     * @since  1.0
     */
    public static function orgnizedCateName($pid,$modelType)
    {
    	$result=array();
		return self::getList($pid,$result,$spac=0,$modelType);
    }
    
    /**
     * This function is  recursive to get the all sub categories.
     * 
     * @param  integer $pid     parent category id
     * @param  array   $result  the final result array
     * @param  integer $spac    repeate number of seprate charactor
     * 
     * @author Wintermelon
     * @since  1.0
     */
    public static function getList($pid=0,&$result,$spac=0,$modelType)
    {
    	$spac=$spac+2;
    	$models=self::findAll(['parent_id'=>$pid,'model_type'=>$modelType]);
    	foreach ($models as $model){
    		$model->name=str_repeat('__',$spac-2).$model->name;
    		$result[]=$model;    		
    		self::getList($model->id,$result,$spac,$modelType);
    	}    	
    	return $result;
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
    		case 'model_type':
    			return [
    			self::MODEL_TYPE_BRAND=>'品牌',
    			self::MODEL_TYPE_GOODS=>'商品',
    			self::MODEL_TYPE_POSTS=>'发帖',
    			];
    			 
    		default:
    			return [];
    	}
    }
    
    public static function getChildIDs($id,$modelType)
    {
    	$ids[]=$id;
    	$childCategories=array();
    	self::getList($id,$childCategories,0,$modelType);
    	if($childCategories)
    	{
    		foreach ($childCategories as $childCategory)
    		{
    			$ids[]=$childCategory->id;
    		}
    	}
    	return $ids;
    }
    
    public static function getCategoryAsMenuItems($pid,$modelType)
    {
    	$menuItems=array();
    	$models=self::findAll(['parent_id'=>$pid,'model_type'=>$modelType]);
    	foreach ($models as $model){
    		$menuItems[]=[
    				'label'=>$model->name,
    				'url' => [$model->model_type.'/search-by-category','category_id'=>$model->id],
    				'items'=>self::getCategoryAsMenuItems($model->id,$modelType),
    		];
    	}
    	return $menuItems;
    }
    
    public static function getCategoryAsMenuItems1($pid,$modelType)
    {
    	$menuItems=array();
    	$models=self::orgnizedCateName(0,$modelType);
    	foreach ($models as $model){
    		$items[]=[
    				'label'=> $model->name,
    				'url' => [$model->model_type.'/search-by-category','category_id'=>$model->id],
    		];
    	}
    	switch ($modelType)
    	{
    		case self::MODEL_TYPE_BRAND:
    			$label='所有品牌分类';
    			break;
    		case self::MODEL_TYPE_GOODS:
    			$label='所有精品分类';
    			break;
    		case self::MODEL_TYPE_POSTS:
    			$label='所有促销分类';
    			break;
    		default:
    			$label='';
    	}
    	if($models)
    	{
    		$menuItems[]=[
    				'label'=>'<span class="glyphicon glyphicon-th-list"></span>'.$label,
    				'items' =>$items,
    		];
    	}
    	
    	//var_dump($menuItems);
    	//die();
    	return $menuItems;
    }
}
