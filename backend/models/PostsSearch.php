<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Posts;

/**
 * PostsSearch represents the model behind the search form about `common\models\Posts`.
 */
 class PostsSearch extends Posts
{
	/**
	 * The searching key words.
	 */
	public $keyWords;	
	/**
	 * The tag id will be searched in the brand models.
	 */
	public $tagid;
	/**
	 * The relationship id and user id  will be searched in the brand models.
	 * If the value be set , the searching will join with the table relationships_map.
	 */
	public $relationship;
	public $relationship_userid;
	/**
	 * The category id or id array will be searched in the brand models.
	 * If the value be set , the searching will join with the  category_map table.
	 */
	public $category_id; 

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'comment_count', 'thumbsup', 'thumbsdown', 'view_count'], 'integer'],
            [['post_title', 'post_content', 'post_status', 'url', 'created_date', 'updated_date', 'effective_date', 'expired_date'], 'safe'],
        	[['relationship','relationship_userid'],'safe'],
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
        $query = Posts::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'pagination' => [
        			'pagesize' => '10',
        	],
        	'sort' => [
        			'defaultOrder' => [
        						'updated_date' => SORT_DESC,
        						'view_count' => SORT_DESC,
        						'comment_count' => SORT_DESC,
        						'thumbsup' => SORT_DESC,
        						'star_count' =>SORT_DESC,
        			]
        	],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        if($this->tagid)
        {
        	$query->joinWith('tagMaps')->where(['tagid'=>$this->tagid]);
        }
        if($this->relationship)
        {
        	$query->joinWith('relationshipsMap')->where(['relationship_id'=>$this->relationship,'relationships_map.userid'=>$this->relationship_userid]);
        }
        if($this->category_id)
        {
        	$query->joinWith('categoryMap')->where(['category_id'=>$this->category_id]);
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            'userid' => $this->userid,
            'comment_count' => $this->comment_count,
            'thumbsup' => $this->thumbsup,
            'thumbsdown' => $this->thumbsdown,
            // 'effective_date' => $this->effective_date,
            // 'expired_date' => $this->expired_date,
            'view_count' => $this->view_count,
        ]);

        $query->orFilterWhere(['like', 'post_title', $this->keyWords])
            ->orFilterWhere(['like', 'post_content', $this->keyWords])
            ->orFilterWhere(['like', 'post_status', $this->keyWords])
            ->orFilterWhere(['like', 'url', $this->keyWords]);

        return $dataProvider;
    }
}
