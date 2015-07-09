<?php

namespace common\models\solr;

use yii;
use yii\data\BaseDataProvider;
use yii\di\Instance;
use SolrClient;
use SolrQuery;

class SolrDataProvider extends BaseDataProvider
{
	/**
	 * @var QueryInterface the query that is used to fetch data models and [[totalCount]]
	 * if it is not explicitly set.
	 */
	public $query;
	/**
	 * @var string|callable the column that is used as the key of the data models.
	 * This can be either a column name, or a callable that returns the key value of a given data model.
	 *
	 * If this is not set, the following rules will be used to determine the keys of the data models:
	 *
	 * - If [[query]] is an [[\yii\db\ActiveQuery]] instance, the primary keys of [[\yii\db\ActiveQuery::modelClass]] will be used.
	 * - Otherwise, the keys of the [[models]] array will be used.
	 *
	 * @see getKeys()
	 */
	public $key;
	/**
	 * @var Connection|array|string the DB connection object or the application component ID of the DB connection.
	 * If not set, the default DB connection will be used.
	 * Starting from version 2.0.2, this can also be a configuration array for creating the object.
	 */
	//public $db;
	public $solr;
	
	
	/**
	 * Initializes the DB connection component.
	 * This method will initialize the [[db]] property to make sure it refers to a valid DB connection.
	 * @throws InvalidConfigException if [[db]] is invalid.
	 */
	public function init()
	{
		parent::init();
		if (is_string($this->solr)) {
			$this->solr = Instance::ensure($this->solr, 'SolrClient');
		}
	}
	
	/**
	 * @inheritdoc
	 */
	protected function prepareModels()
	{
		/* if (!$this->query instanceof QueryInterface) {
			throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
		}
		$query = clone $this->query;
		if (($pagination = $this->getPagination()) !== false) {
			$pagination->totalCount = $this->getTotalCount();
			$query->limit($pagination->getLimit())->offset($pagination->getOffset());
		}
		if (($sort = $this->getSort()) !== false) {
			$query->addOrderBy($sort->getOrders());
		}
	
		return $query->all($this->db); */
		if (!$this->query instanceof SolrQuery) {
		 throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
		 }
		 //$query = $this->query;
		 if (($pagination = $this->getPagination()) !== false) {
  		 $pagination->totalCount = $this->getTotalCount();
// // 		 $this->query->setRows(10);
// // 		 $this->query->setStart(0);
  		 	$this->query->setRows($pagination->getLimit())->setStart($pagination->getOffset());
		 }
 		 if (($sort = $this->getSort()) !== false) {
 		 //$query->addOrderBy($sort->getOrders());
 		 	$orders=$sort->orders;
 		 	foreach ($orders as $field=>$order)
 		 	{
 		 		$this->query->addSortField($field,$order);
 		 	}
 		 }
		 //$response=$solr->query($query)->getResponse();
		 
		 //var_dump($this->query);
		 
		 ///die();
		
		 return $this->solr->query($this->query)->getResponse()->response->docs; 
	}
	
	/**
	 * @inheritdoc
	 */
	protected function prepareKeys($models)
	{
// 		$keys = [];
// 		if ($this->key !== null) {
// 			foreach ($models as $model) {
// 				if (is_string($this->key)) {
// 					$keys[] = $model[$this->key];
// 				} else {
// 					$keys[] = call_user_func($this->key, $model);
// 				}
// 			}
	
// 			return $keys;
// 		} elseif ($this->query instanceof ActiveQueryInterface) {
// 			/* @var $class \yii\db\ActiveRecord */
// 			$class = $this->query->modelClass;
// 			$pks = $class::primaryKey();
// 			if (count($pks) === 1) {
// 				$pk = $pks[0];
// 				foreach ($models as $model) {
// 					$keys[] = $model[$pk];
// 				}
// 			} else {
// 				foreach ($models as $model) {
// 					$kk = [];
// 					foreach ($pks as $pk) {
// 						$kk[$pk] = $model[$pk];
// 					}
// 					$keys[] = $kk;
// 				}
// 			}
	
// 			return $keys;
// 		} else {
// 			return array_keys($models);
// 		}

				$keys = [];
				if ($this->key !== null) {
					foreach ($models as $model) {
						if (is_string($this->key)) {
							$keys[] = $model[$this->key];
						} else {
							$keys[] = call_user_func($this->key, $model);
						}
					}
		
					return $keys;
				}else {
			return array_keys($models);
		}
	}
	
	/**
	 * @inheritdoc
	 */
	protected function prepareTotalCount()
	{
		if (!$this->query instanceof SolrQuery) {
			throw new InvalidConfigException('The "query" property must be an instance of a class that implements the QueryInterface e.g. yii\db\Query or its subclasses.');
		}
		//$query = clone $this->query;
		return $this->solr->query($this->query)->getResponse()->response->numFound;

	}
	
	/**
	 * @inheritdoc
	 */
	public function setSort($value)
	{
// 		parent::setSort($value);
// 		if (($sort = $this->getSort()) !== false && $this->query instanceof ActiveQueryInterface) {
// 			/* @var $model Model */
// 			$model = new $this->query->modelClass;
// 			if (empty($sort->attributes)) {
// 				foreach ($model->attributes() as $attribute) {
// 					$sort->attributes[$attribute] = [
// 							'asc' => [$attribute => SORT_ASC],
// 							'desc' => [$attribute => SORT_DESC],
// 							'label' => $model->getAttributeLabel($attribute),
// 					];
// 				}
// 			} else {
// 				foreach($sort->attributes as $attribute => $config) {
// 					if (!isset($config['label'])) {
// 						$sort->attributes[$attribute]['label'] = $model->getAttributeLabel($attribute);
// 					}
// 				}
// 			}
// 		}
				parent::setSort($value);
				
				//var_dump($value);
				
// 				var_dump($this->getSort());
				
// 				var_dump($this->query);
			
				if (($sort = $this->getSort()) !== false && $this->query instanceof SolrQuery) {
					//var_dump($this->getSort());
					/* @var $model Model */
					$model = $this->query->getFields();
					//var_dump($this->query);
					//var_dump($model);
					//die();
					if($model)
					{
						if (empty($sort->attributes)) {
							foreach ($model  as $key=>$attribute) {
								$sort->attributes[$attribute] = [
										'asc' => [$attribute => SolrQuery::ORDER_ASC],
										'desc' => [$attribute => SolrQuery::ORDER_DESC],
										'label' => $attribute,
								];
							}
							//var_dump($sort);
						} else {
							foreach($sort->attributes as $attribute => $config) {
								if (!isset($config['label'])) {
									$sort->attributes[$attribute]['label'] = $attribute;
								}
							}
						}
					}
					
				}

	}
}