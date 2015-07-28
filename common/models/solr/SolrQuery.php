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
	
	
	/**
	 * Allow user can add the fields throug a array.
	 * 
	 * @param array $fields
	 */
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
	
	/**
	 * Let the field has one label to show. Now is used by the sort component.
	 * The sort object can show the field in label by the user setting.
	 * 
	 * @return array|multitype:unknown array 
	 */
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