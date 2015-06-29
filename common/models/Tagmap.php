<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tagmap".
 *
 * @property integer $id
 * @property integer $tagid
 * @property string $model_type
 * @property integer $model_id
 */
class Tagmap extends \yii\db\ActiveRecord
{
	const MODEL_TYPE_GOODS='goods';
	const MODEL_TYPE_POSTS='posts';
	const MODEL_TYPE_BRAND='brand';
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tagmap';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tagid', 'model_id'], 'integer'],
            [['model_type'], 'string', 'max' => 20],
        	[['tagid', 'model_type','model_id'], 'unique', 'targetAttribute' => ['tagid', 'model_type','model_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tagid' => 'Tagid',
            'model_type' => 'Model Type',
            'model_id' => 'Model ID',
        ];
    }
    
    public function getTag()
    {
    	return $this->hasOne(Tag::className(), ['id'=>'tagid']);
    	//->where(['model_type'=>$this->model_type]);
    	//->all();
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
       if (parent::beforeDelete()) {
    	// ...custom code here...
    	$tag=$this->tag;
    	if($tag)
    	{
    		$tag->updateCounters(['count'=>-1]);
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
   			$tag=$this->tag;
   			if($tag){
   				$tag->updateCounters(['count'=>1]);
   			}
   			 return true;
   		} else {
   			return false;
   		}
   	}
   	

   	/**
   	 * This function is to get the model of this tagmap record.
   	 * 得到标签映射记录对应的数据模型记录
   	 *
   	 * @author Wintermelon
   	 * @since  1.0
   	 */
   	public function getModel()
   	{
   	    switch ($this->model_type){
    		case self::MODEL_TYPE_POST:
    			return Posts::findOne(['id'=>$this->model_id]);
    		case self::MODEL_TYPE_GOODS:
    			return Goods::findOne(['id'=>$this->model_id]);
    		case self::MODEL_TYPE_BRAND:
    			return Brand::findOne(['id'=>$this->model_id]);
    		default:
    			return null;
    	}
   	}
   	
}
