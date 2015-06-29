<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comment;

/**
 * CommentSearch represents the model behind the search form about `common\models\Comment`.
 */
class CommentSearch extends Comment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'model_id', 'thumbsup', 'thumbsdown', 'userid'], 'integer'],
        	[['id', 'parent_id', 'model_id', 'thumbsup', 'thumbsdown', 'userid'], 'safe'],
            [['model_type', 'approved', 'content', 'created_date', 'updated_date', 'author', 'author_ip'], 'safe'],
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
        $query = Comment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        		'pagination' => [
        				'pagesize' => '5',
        		],
        		'sort' => [
        				'defaultOrder' => [
        						'created_date' => SORT_DESC,
        				]
        		],
        ]);

        $this->load($params);
        
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'model_id' => $this->model_id,
            'thumbsup' => $this->thumbsup,
            'thumbsdown' => $this->thumbsdown,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'userid' => $this->userid,
        ]);

        $query->andFilterWhere(['like', 'model_type', $this->model_type])
            ->andFilterWhere(['like', 'approved', $this->approved])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'author_ip', $this->author_ip]);

        return $dataProvider;
    }
}
