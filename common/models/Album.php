<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;


/**
 * This is the model class for table "album".
 *
 * @property integer $id
 * @property string $model_type
 * @property integer $model_id
 * @property string $filename
 * @property string $created_date
 * @property string $updated_date
 * @property integer $is_default
 */
class Album extends \yii\db\ActiveRecord
{
	const MODEL_TYPE_GOODS='goods';
	const MODEL_TYPE_COMMENT='comment';
	const MODEL_TYPE_POSTS='posts';
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_type', 'model_id'], 'required'],
            [['model_id', 'is_default'], 'integer'],
        	[['is_default'], 'default','value'=>0],
            [['created_date', 'updated_date'], 'safe'],
            [['model_type'], 'string', 'max' => 20],
            [['filename'], 'string', 'max' => 255]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
    	return [
    			[
    					'class' => TimestampBehavior::className(),
    					'createdAtAttribute' => 'created_date',
    					'updatedAtAttribute' => 'updated_date',
    					'value' => new Expression('NOW()'),
    			],
    	];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_type' => 'Model Type',
            'model_id' => 'Model ID',
            'filename' => 'Filename',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'is_default' => 'Is Default',
        ];
    }
    
//    public function beforeSave($insert)
//    {
//     	if (parent::beforeSave($insert)) {
//     		// ...custom code here...
//     		if($this->model_type==MODEL_TYPE_POSTS)
//     		{
//     			//$this->is_default=1;
//     		}
//     		return true;
//     	} else {
//     		return false;
//     	}
//    }
	
	public function beforeDelete() 
	{
		if(parent::beforeDelete())
		{
			if($this->filename)
			{
				if(file_exists($this->filename))
				{
					unlink($this->filename);
				}
			}
			return true;
		}
		else 
		{
			return false;
		}
		
	}
	
	public function setDefault()
	{
		self::updateAll(['is_default'=>0],['model_type'=>$this->model_type,'model_id'=>$this->model_id]);
		$this->is_default=true;
		$this->save();
	}

}
