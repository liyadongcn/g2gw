<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "relationships_map".
 *
 * @property integer $id
 * @property integer $relationship_id
 * @property integer $userid
 * @property string $model_type
 * @property integer $model_id
 */
class RelationshipsMap extends \yii\db\ActiveRecord
{
	const MODEL_TYPE_GOODS='goods';
	const MODEL_TYPE_COMMENT='comment';
	const MODEL_TYPE_POST='posts';
	const MODEL_TYPE_BRAND='brand';
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_date'],
                ],
            ],
        ];
	}
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relationships_map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['relationship_id', 'userid', 'model_id'], 'integer'],
        	[['relationship_id', 'userid', 'model_id','model_type'], 'unique','targetAttribute' => ['relationship_id', 'userid', 'model_id','model_type']],
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
            'relationship_id' => 'Relationship ID',
            'userid' => 'Userid',
            'model_type' => 'Model Type',
            'model_id' => 'Model ID',
        	'created_date' => 'Created date',
        ];
    }
    
    /**
     * This function is to get the all relationship record of the relationshipsmap.
     *
     *
     * @author Wintermelon
     * @since  1.0
     */
    public function getRelationship()
    {
    	return $this->hasOne(RelationshipsMap::className(), ['id'=>'relationship_id']);
    	//->where(['model_type'=>$this->modelType(),'parent_id'=>0]);
    	//->all();
    }
    
    /**
     * This function is to get the model record of the relationshipsmap.
     *
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
