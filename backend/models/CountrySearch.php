<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Country;

/**
 * CountrySearch represents the model behind the search form about `common\models\Country`.
 */
class CountrySearch extends Country
{
    public $keyWords;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'en_name', 'cn_name', 'flag','keyWords'], 'safe'],
            [['population'], 'integer'],
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
        $query = Country::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'pagination' => [
                'pagesize' => '5',
        		]
         ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

/*        $query->andFilterWhere([
            'population' => $this->population,
        ]);
*/
        $query->orFilterWhere(['like', 'code', $this->keyWords])
            ->orFilterWhere(['like', 'en_name', $this->keyWords])
            ->orFilterWhere(['like', 'cn_name', $this->keyWords])
            ->orFilterWhere(['like', 'flag', $this->keyWords]);

        return $dataProvider;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'keyWords' => '输入关键字',
        ];
    }
    
}

