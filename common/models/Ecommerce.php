<?php

namespace common\models;

use Yii;
use common\models\Brand;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ecommerce".
 *
 * @property integer $id
 * @property integer $brand_id
 * @property string $website
 * @property string $name
 * @property integer $is_domestic
 * @property integer $accept_order
 */
class Ecommerce extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ecommerce';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_id', 'is_domestic', 'accept_order'], 'integer'],
            [['website'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 30],
            [['name','website'], 'required'],
        	[['is_domestic', 'accept_order'], 'default','value'=>true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand ID',
            'website' => 'Website',
            'name' => 'Name',
            'is_domestic' => 'Is Domestic',
            'accept_order' => 'Accept Order',
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
    public static function getDropDownListData($field)
    {
    	//put more fields need to be mapped.
    	switch ($field)
    	{
    		case 'is_domestic':
    			return [
    				true=>'国内网',
    				false=>'国外网'
    			];
    		case 'accept_order':
    			return [
    				true=>'可在线购买',
    				false=>'不可在线购买'
    			];
    		case 'brand_id':	
    			return ArrayHelper::map(Brand::find()->all(),'id','en_name');
    			
    		default:
    			return [];
    	}
    }
}
