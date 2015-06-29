<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Goods;

/**
 * GoodsSearch represents the model behind the search form about `common\models\Goods`.
 */
class GoodsSearch extends Goods
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
	public $userid;
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
            [['id', 'brand_id', 'thumbsup', 'thumbsdown', 'comment_count', 'recomended_count', 'view_count'], 'integer'],
            [['code', 'description', 'url', 'title', 'comment_status', 'created_date', 'updated_date'], 'safe'],
        	[['keyWords'], 'safe'],
        	[['relationship','userid'],'safe'],
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
        $query = Goods::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        		'pagination'=>[
        				'pagesize'=>15,
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
        	$query->joinWith('relationshipsMap')->where(['relationship_id'=>$this->relationship,'userid'=>$this->userid]);
        }
        if($this->category_id)
        {
        	$query->joinWith('categoryMap')->where(['category_id'=>$this->category_id]);
        }

         $query->andFilterWhere([
            'id' => $this->id,
            'brand_id' => $this->brand_id,
            'thumbsup' => $this->thumbsup,
            'thumbsdown' => $this->thumbsdown,
            'comment_count' => $this->comment_count,
            'created_date' => $this->created_date,
            'updated_date' => $this->updated_date,
            //'interested_count' => $this->interested_count,
            //'recomended_count' => $this->recomended_count,
            'view_count' => $this->view_count,
        ]); 

        $query->orFilterWhere(['like', 'code', $this->keyWords])
            ->orFilterWhere(['like', 'description', $this->keyWords])
            ->orFilterWhere(['like', 'url', $this->keyWords])
            ->orFilterWhere(['like', 'title', $this->keyWords]);
 /*            ->andFilterWhere(['like', 'comment_status', $this->comment_status]); */

        return $dataProvider;
    }
}
