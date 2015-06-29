<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ecommerce;

/**
 * EcommerceSearch represents the model behind the search form about `common\models\Ecommerce`.
 */
class EcommerceSearch extends Ecommerce
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'is_domestic', 'accept_order'], 'integer'],
            [['website', 'name'], 'safe'],
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
        $query = Ecommerce::find();

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
            'brand_id' => $this->brand_id,
            'is_domestic' => $this->is_domestic,
            'accept_order' => $this->accept_order,
        ]);

        $query->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
