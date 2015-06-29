<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "goodscomment".
 *
 * @property string $id
 * @property string $user_id
 * @property string $goods_id
 * @property string $comment
 * @property string $timestamp
 */
class GoodsComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goodscomment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'goods_id'], 'required'],
            [['user_id', 'goods_id'], 'integer'],
            [['comment'], 'string'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'goods_id' => 'Goods ID',
            'comment' => 'Comment',
            'timestamp' => 'Timestamp',
        ];
    }
}
