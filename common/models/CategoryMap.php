<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Goods;
use common\models\Category;

/**
 * This is the model class for table "category_map".
 *
 * @property integer $id
 * @property integer $model_id
 * @property string $model_type
 * @property integer $category_id
 */
class CategoryMap extends \yii\db\ActiveRecord
{
	const MODEL_TYPE_GOODS='Goods';
	const MODEL_TYPE_POSTS='Posts';
	const MODEL_TYPE_BRAND='Brand';
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category_map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['model_id', 'category_id'], 'required'],
           [['model_id', 'category_id'], 'integer'],
           [['model_type'], 'string', 'max' => 20],
           [['category_id', 'model_type','model_id'], 'unique', 'targetAttribute' => ['category_id', 'model_type','model_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'model_type' => 'Model Type',
            'category_id' => 'Category ID',
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
    		case 'model_id':
                switch($this->model_type)
                {
                    case self::MODEL_TYPE_GOODS:
                        return ArrayHelper::map(Goods::find()->all(),'id','title');
                    case self::MODEL_TYPE_BRAND:
                        return ArrayHelper::map(Brand::find()->all(),'id','en_name');
                    case self::MODEL_TYPE_POSTS:
                        return ArrayHelper::map(Posts::find()->all(),'id','post_title');
                    default:
                        return [];
                }
    			
    		case 'category_id':
                switch($this->model_type)
                {
                    case self::MODEL_TYPE_GOODS:
                        return ArrayHelper::map(Category::orgnizedCateName(0,self::MODEL_TYPE_GOODS),'id','name');
                    case self::MODEL_TYPE_BRAND:
                        return ArrayHelper::map(Category::orgnizedCateName(0,self::MODEL_TYPE_BRAND),'id','name');
                    case self::MODEL_TYPE_POSTS:
                        return ArrayHelper::map(Category::orgnizedCateName(0,self::MODEL_TYPE_POSTS),'id','name');
                }
  		//put more fields need to be mapped.
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
    
    public function getCategory()
    {
    	return Category::findOne(['id'=>$this->category_id]);
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
    	if (parent::beforeDelete()) {
    		// ...custom code here...
    		$category=$this->category;
    		if($category)
    		{
    			$category->updateCounters(['count'=>-1]);
    		}
    		return true;
    	} else {
    		return false;
    	}
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
    	if (parent::beforeSave($insert)) {
    		// ...custom code here...
    		$category=$this->category;
    		if($category){
    			$category->updateCounters(['count'=>1]);
    		}
    		return true;
    	} else {
    		return false;
    	}
    }
}
