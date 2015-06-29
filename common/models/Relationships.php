<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "relationships".
 *
 * @property integer $id
 * @property string $name
 */
class Relationships extends \yii\db\ActiveRecord
{
	const RELATIONSHIP_STAR=2;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relationships';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
        	[['name'], 'unique'],
            [['name'], 'string', 'max' => 20]
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
        ];
    }
}
