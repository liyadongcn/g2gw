<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tagmap;

/**
 * TagmapSearch represents the model behind the search form about `common\models\Tagmap`.
 */
class TagmapSearch extends Tagmap
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tagid', 'model_id'], 'integer'],
            [['model_type'], 'safe'],
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
        $query = Tagmap::find();

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
            'tagid' => $this->tagid,
            'model_id' => $this->model_id,
        ]);

        $query->andFilterWhere(['like', 'model_type', $this->model_type]);

        return $dataProvider;
    }
}
