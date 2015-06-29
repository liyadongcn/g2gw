<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $telphone
 * @property string $fax
 * @property string $contact
 * @property string $cell
 * @property string $qq
 * @property string $vchat
 * @property string $email
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
            [['telphone', 'fax', 'qq', 'vchat'], 'string', 'max' => 20],
            [['contact'], 'string', 'max' => 30],
            [['cell'], 'string', 'max' => 11]
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
            'address' => 'Address',
            'telphone' => 'Telphone',
            'fax' => 'Fax',
            'contact' => 'Contact',
            'cell' => 'Cell',
            'qq' => 'Qq',
            'vchat' => 'Vchat',
            'email' => 'Email',
        ];
    }
}
