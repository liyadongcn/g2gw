<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "links".
 * 
 * This is used by the goods,posts model. Any goods or post can has one or more links.
 *
 * @property integer $id
 * @property string $link_url
 * @property string $link_promotion
 * @property string $link_name
 * @property string $link_description
 * @property string $model_type
 * @property integer $model_id
 * @property string $created_date
 * @property string $updated_date
 * @property integer $status
 */
class Links extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'model_id', 'status'], 'integer'],
            [['link_description', 'link_promotion'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['link_url'], 'string', 'max' => 500],
            [['link_name', 'model_type'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link_url' => 'Link Url',
            'link_promotion' => 'Link Promotion',
            'link_name' => 'Link Name',
            'link_description' => 'Link Description',
            'model_type' => 'Model Type',
            'model_id' => 'Model ID',
            'created_date' => 'Created Date',
            'updated_date' => 'Updated Date',
            'status' => 'Status',
        ];
    }
    
    /**
     * Get the model link string. If the model has the promotion link, it will return the promotion link
     * otherwise it will return the oringinal link.
     * 
     * @author wintermelon
     * @return string
     */
    public function getLink()
    {
    	return (empty($this->link_promotion)) ? $this->link_url : $this->link_promotion;
    }
}
