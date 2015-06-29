<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pricehistory".
 *
 * @property integer $id
 * @property integer $goods_id
 * @property double $market_price
 * @property double $real_price
 * @property string $quotation_date
 */
class Pricehistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pricehistory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'quotation_date'], 'required'],
            [['goods_id'], 'integer'],
            [['market_price', 'real_price'], 'number'],
            [['quotation_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'market_price' => 'Market Price',
            'real_price' => 'Real Price',
            'quotation_date' => 'Quotation Date',
        ];
    }
}
