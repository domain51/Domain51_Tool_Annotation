<?php

require_once 'Domain51/Tool/Annotation/Collection.php';

class Domain51_Tool_Annotation_Parser
{
	public function parse($string)
	{
		$collection = new Domain51_Tool_Annotation_Collection();
		if (!preg_match_all('/@([a-z]+) ?(.*)/i', $string, $matches)) {
			return $collection;
		}
		
		foreach ($matches[1] as $key => $match) {
			$params = !empty($matches[2][$key]) ? explode(' ', $matches[2][$key]) : array();
			
			$collection->add(new Domain51_Tool_Annotation_Value($match, $params));
		}
		return $collection;
	}
}