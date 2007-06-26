<?php

require_once 'Domain51/Tool/Annotation/Value.php';

class Domain51_Tool_Annotation_Collection implements Iterator
{
	private $_cursor = 0;
	private $_stack = array();
	
	public function add(Domain51_Tool_Annotation_Value $annotation)
	{
		$this->_stack[] = $annotation;
	}
	
	public function count()
	{
		return count($this->_stack);
	}
	
	public function has($name)
	{
		$stackCount = $this->count();
		for ($i = 0; $i < $stackCount; $i++) {
			if ($this->_stack[$i]->name == $name) {
				return true;
			}
		}
		return false;
	}
	
	public function filter($names)
	{
		$names = (array)$names;
		
		$return = new self();
		$stackCount = $this->count();
		for ($i = 0; $i < $stackCount; $i++) {
			if (in_array($this->_stack[$i]->name, $names)) {
				$return->add($this->_stack[$i]);
			}
		}
		
		return $return;
	}
	
	public function filterOut($names)
	{
		$names = (array)$names;
		
		$return = new self();
		$stackCount = $this->count();
		for ($i = 0; $i < $stackCount; $i++) {
			if (!in_array($this->_stack[$i]->name, $names)) {
				$return->add($this->_stack[$i]);
			}
		}
		
		return $return;
	}
	
	public function current()
	{
		return $this->_stack[$this->_cursor];
	}
	
	public function key()
	{
		return $this->valid() ? $this->_cursor : null;
	}
	
	public function next()
	{
		$this->_cursor++;
	}
	
	public function rewind()
	{
		$this->_cursor = 0;
	}
	
	public function valid()
	{
		return $this->_cursor < $this->count();
	}
}