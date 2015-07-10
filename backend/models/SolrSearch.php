<?php


namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\solr\SolrDataProvider;
use SolrClient;
use common\models\solr\SolrQuery;

/**
 * SolrSearch represents the model behind the search form about solr server searching.
 */
class SolrSearch extends Model
{
	/**
	 * The searcModelkey words.
	 */
	public $keyWords;
	
	/**
	 * @return array | Fields of solr response.
	 */
	public static function getSolrResponseFields()
	{
		return [
				'id'=>'唯一标识',
				'tstamp'=>'时间',
				'title'=>'标题',
				'url'=>'url',
				//'content'=>'content',
		];
	}
	

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
				[['keyWords'], 'safe'],
				[['keyWords'],'default','value'=>'*'],
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
	 * @return SolrDataProvider
	 */
	public function search($params)
	{
		//echo solr_get_version();
		$options = array
		(
				'hostname' => SOLR_SERVER_HOSTNAME,
				'login'    => SOLR_SERVER_USERNAME,
				'password' => SOLR_SERVER_PASSWORD,
				'port'     => SOLR_SERVER_PORT,
				'path'     => SOLR_SERVER_PATH,
				'wt'       => 'json',
		
		);
		
		$client = new SolrClient($options);
		
		$query = new SolrQuery();
		
		if($this->keyWords)
		{
			$query->setQuery('title:'.$this->keyWords);
		}
		else
		{
			$query->setQuery('*:*');
		}
		
		$responseFields=self::getSolrResponseFields();
		
		$query->addFields($responseFields);
		
// 		$query->setHighlight(0);
		
// 		$query->addHighlightField('title');
		
// 		$query->addField('id');
		
// 		$query->addField('tstamp');
		
// 		$query->addField('title');
		
// 		//$query->addField('content');
		
// 		$query->addField('url');
		
		// 		$query->addField('id')->addField('title');
		
		// 		$query->setStart(0);
		
		// 		$query->setRows(10);
		
		$dataProvider=new SolrDataProvider([
				'solr' => $client,
				'query' => $query,
				'pagination' => [
						'pagesize' => '15',
				],
				'sort' => [
						'defaultOrder' => [
								'title' => SolrQuery::ORDER_ASC,
								'id' => SolrQuery::ORDER_ASC,
								//'tstamp' => SolrQuery::ORDER_DESC,
						]
				],
		]);
		
		$this->load($params);
		
		if (!$this->validate()) {
			// uncomment the following line if you do not want to any records when validation fails
			// $query->where('0=1');
			return $dataProvider;
		}
		
		// 		$dataProvider->solr=$client;
		
		// 		$dataProvider->query=$query;
		
		//$dataProvider->pagination->pagesize=5;
		
		//var_dump($dataProvider);
		
		// 		echo $query;
		
		// 		die();
		
		return $dataProvider;
		
		/* $models=$dataProvider->models;
		
		echo $dataProvider->getTotalCount();
		
		foreach ($models as $doc)
		{
		echo "id:".$doc->id."</br>";
		echo "titles:"."</br>";
		foreach ($doc->title as $title)
		{
		echo "&nbsp&nbsp".$title."</br>";
		}
		} */
		
		
		
		/* 		$query_response = $client->query($query);
		
		$response = $query_response->getResponse();
		
		print_r($response);
		
		echo "////////////////////////////////////";
		
		var_dump($response['responseHeader']);
		
		foreach ($response->response->docs as $doc)
		{
		echo "id:".$doc->id."</br>";
		echo "titles:"."</br>";
		foreach ($doc->title as $title)
		{
		echo "&nbsp&nbsp".$title."</br>";
		}
		
		}
		*/
	}
}
