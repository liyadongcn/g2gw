<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 */
class AuthItem extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            ['type','default','value'=>0],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            ['rule_name', 'default','value'=>null],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('messages', 'Name'),
            'type' => Yii::t('messages', 'Type'),
            'description' => Yii::t('messages', 'Description'),
            'rule_name' => Yii::t('messages', 'Rule Name'),
            'data' => Yii::t('messages', 'Data'),
            'created_at' => Yii::t('messages', 'Created At'),
            'updated_at' => Yii::t('messages', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren0()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }
}
