<?php

/**
 * Extends the SolrQuery to surpport the sort widget.
 * 
 * Make the response field with the lable you want.
 * 
 * @author LIYADONG
 *
 */
namespace common\models\solr;

//use SolrQuery;

class SolrQuery extends \SolrQuery
{
	private $_fields;
	
	public function addFields($fields)
	{
		if(is_array($fields))
		{
			foreach ($fields as $key=>$lable)
			{
				$this->addField($key);
			}
			$this->_fields=$fields;	
		}	
	}
	
	public function getFieldsWithLable()
	{
		if(isset($this->_fields))
		{
			return $this->_fields;
		}
		else
		{
			$fields=$this->getFields();
			foreach ($fields as $field)
			{
				$fieldsWithLable[]=[$field,$field];
			}
			return $fieldsWithLable;
		}
	}
}