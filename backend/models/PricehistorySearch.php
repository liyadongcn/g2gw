<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Pricehistory;

/**
 * PricehistorySearch represents the model behind the search form about `common\models\Pricehistory`.
 */
class PricehistorySearch extends Pricehistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'goods_id'], 'integer'],
            [['market_price', 'real_price'], 'number'],
            [['quotation_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Pricehistory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'goods_id' => $this->goods_id,
            'market_price' => $this->market_price,
            'real_price' => $this->real_price,
            'quotation_date' => $this->quotation_date,
        ]);

        return $dataProvider;
    }
}
