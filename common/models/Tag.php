<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;
use backend\models\GoodsSearch;
use backend\models\BrandSearch;
use backend\models\PostsSearch;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $count
 */
class Tag extends \yii\db\ActiveRecord
{
	const MODEL_TYPE_GOODS='goods';
	const MODEL_TYPE_POSTS='posts';
	const MODEL_TYPE_BRAND='brand';
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count'], 'integer'],
        	[['count'], 'default','value'=>0],
            [['name'], 'string', 'max' => 20],
        	[['name','model_type'], 'unique', 'targetAttribute' => ['name','model_type']]   //Tag name should be unique under the model type.
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'count' => 'Count',
        ];
    }
    
    /**
     * This function is to get the hotest of tags.
     *
     * @param integer the number of the records needed. the default is 10.
     * @return array|null the model objects
     *
     * @author Wintermelon
     * @since  1.0
     */
    public static function getHotestTags($modelType,$n=20)
    {
    	$query=self::find();
    	$query->where(['model_type'=>$modelType])->orderBy(['count' => SORT_DESC])
    	->limit($n);
    	return $query;
    
    }
    
    /**
     * This function is to get the all tags map records of this brand.
     * 得到数据模型的所有标签映射记录
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getTagMaps()
    {
    	return $this->hasMany(Tagmap::className(), ['tagid'=>'id']);
    	//->where(['model_type'=>$this->model_type])
    	//->all();
    }
    
    /**
     * This function is to get the all models records have the same tag.
     * 得到该标签对应的所有数据模型记录
     *
     * @return ActiveDataProvider
     * 
     * @author Wintermelon
     * @since  1.0
     */
    public function getModels()
    {

    	$ids=$this->getModelIDs();
    	
    	switch ($this->model_type){
    		case self::MODEL_TYPE_POSTS:
    			$searchModel=new PostsSearch();
    			break;
    		case self::MODEL_TYPE_GOODS:
    			$searchModel=new GoodsSearch();
    			break;
    		case self::MODEL_TYPE_BRAND:
    			$searchModel=new BrandSearch();
    			break;
    	}
    	//echo StringHelper::basename($searchModel->className());
    	//var_dump($ids);    	
    	//die();
    	$searchModel->ids=$ids;
    	$dataProvider=$searchModel->search([]);
    	return $dataProvider;
    }
 
    /**
     * This function is to get the all models records ID have the same tag.
     * 得到该标签对应的所有数据模型记录的ID艺术组的形式返回
     *
     * @return array 
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getModelIDs()
    {
    	
    	$tagMaps=$this->tagMaps;
    	//var_dump($tagMaps);
    	$ids=array();
    	if ($tagMaps)
    	{
    		foreach ($tagMaps as $tagMap)
    		{
    			$ids[]=$tagMap->model_id;
    		}
    	}
    	return $ids;
    }
}
