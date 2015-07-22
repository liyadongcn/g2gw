<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use common\models\Brand;

/**
 * BrandSearch represents the model behind the search form about `common\models\Brand`.
 */
class BrandSearch extends Brand
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
            [['id', 'thumbsup', 'thumbsdown', 'company_id', 'comment_count', 'view_count'], 'integer'],
            [['en_name', 'country_code', 'logo', 'cn_name', 'introduction', 'baidubaike'], 'safe'], 
        	['keyWords','safe'],
        	[['relationship','userid','country_code'],'safe'],
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
        $query = Brand::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'pagination' => [
                'pagesize' => '24',
        	],
        	'sort' => [
        			'defaultOrder' => [
                            'updated_date' => SORT_DESC,
        					'view_count' => SORT_DESC,
        					'thumbsup' => SORT_DESC,
        					'comment_count' =>SORT_DESC,        					
        					'star_count' =>SORT_DESC,
        			]
        	],
        ]);
        
       // var_dump($params);
       

        $this->load($params);
        
//         echo $this->relationship;
//         echo $this->userid;
//         die();
        
        //var_dump($this->ids);
       // die();

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
        	$query->joinWith('relationshipsMap')->where(['relationship_id'=>$this->relationship,'relationships_map.userid'=>$this->userid]);
        }
        if($this->category_id)
        {
        	$query->joinWith('categoryMap')->where(['category_id'=>$this->category_id])->groupBy(['id']);
        }
       

         $query->andFilterWhere([
            'id' => $this->id,
            //'thumbsup' => $this->thumbsup,
            //'thumbsdown' => $this->thumbsdown,
            //'company_id' => $this->company_id,
            //'comment_count' => $this->comment_count,
            //'view_count' => $this->view_count,
        ]);
 
        $query->orFilterWhere(['like', 'en_name', $this->keyWords])
             ->orFilterWhere(['like', 'country_code', $this->country_code])
//             ->andFilterWhere(['like', 'logo', $this->logo])
            ->orFilterWhere(['like', 'cn_name', $this->keyWords])
            ->orFilterWhere(['like', 'introduction', $this->keyWords]);
//             ->andFilterWhere(['like', 'baidubaike', $this->baidubaike]);

        return $dataProvider;
    }
    
}
