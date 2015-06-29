<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use common\models\AuthItem;
use common\models\User;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property integer $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['created_at','user_id'], 'integer'],
            [['item_name'], 'string', 'max' => 64],
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id'],'message' => '用户权限已经分配！'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => Yii::t('messages', 'Item Name'),
            'user_id' => Yii::t('messages', 'User ID'),
            'created_at' => Yii::t('messages', 'Created At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
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
    public function getDropDownListData($field)
    {
        switch ($field)
        {
            case 'item_name':
                return ArrayHelper::map(AuthItem::find()->all(),'name','description');
            case 'user_id':
                return ArrayHelper::map(User::find()->all(),'id','username');
            //put more fields need to be mapped.
                
            default:
                return [];
        }
    }
}
