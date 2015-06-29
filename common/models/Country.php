<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property string $code
 * @property string $en_name
 * @property integer $population
 * @property string $cn_name
 * @property string $flag
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'en_name', 'cn_name'], 'required'],
            // [['population'], 'default','value'=>0],
        	[['population'], 'integer','message'=>'必须是数字'],
            [['code'], 'string', 'max' => 3],
            [['en_name', 'cn_name'], 'string', 'max' => 20],
            [['flag'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'en_name' => 'En Name',
            'population' => 'Population',
            'cn_name' => 'Cn Name',
            'flag' => 'Flag',
        ];
    }
}
