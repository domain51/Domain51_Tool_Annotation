<?php

require_once 'Domain51/Tool/Annotation/Collection.php';
require_once 'Domain51/Tool/Annotation/ParamsHelper.php';
require_once 'Domain51/Tool/Annotation/ParamsHelper/ExplodeOnWhitespace.php';
require_once 'Domain51/Tool/Annotation/Parser/Exception.php';

class Domain51_Tool_Annotation_Parser
{
	private $_paramsHelper = null;
	
	public function __construct()
	{
		$this->_paramsHelper = new Domain51_Tool_Annotation_ParamsHelper_ExplodeOnWhitespace();
	}
	
	public function __set($key, $value)
	{
		if ($key != 'paramsHelper') {
			return;
		}
		
		if (!$value instanceof Domain51_Tool_Annotation_ParamsHelper) {
			throw new Domain51_Tool_Annotation_Parser_Exception(
				'paramsHelper can only be set to an object that implements Domain51_Tool_Annotation_ParamsHelper'
			);
		}
		
		$this->_paramsHelper = $value;
	}
	
	public function parse($string)
	{
		$collection = new Domain51_Tool_Annotation_Collection();
		if (!preg_match_all('/@([a-z]+) ?(.*)/i', $string, $matches)) {
			return $collection;
		}
		
		foreach ($matches[1] as $key => $match) {
			$params = array();
			if (!empty($matches[2][$key])) {
				$params = $this->_paramsHelper->parse($matches[2][$key]);
			}
			
			$collection->add(new Domain51_Tool_Annotation_Value($match, $params));
		}
		return $collection;
	}
}