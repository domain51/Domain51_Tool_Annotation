<?php

require_once 'Domain51/Tool/Annotation/Value/Exception.php';

class Domain51_Tool_Annotation_Value
{
	private $_name = null;
	private $_params = array();
	
	public function __construct($name, array $params = array())
	{
		if (!is_string($name)) {
			throw new Domain51_Tool_Annotation_Value_Exception(
				'non-string provided for name at construct'
			);
		}
		$this->_name = $name;
		$this->_params = $params;
	}
	
	public function __get($key)
	{
		switch ($key) {
			case 'name':
			case 'params':
				$real_key = "_{$key}";
				return $this->$real_key;
		}
	}
	
	public function __set($key, $value)
	{
		throw new Domain51_Tool_Annotation_Value_Exception();
	}
}