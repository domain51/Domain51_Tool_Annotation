<?php

require_once dirname(__FILE__) . '/../../../bootstrap.php';
require_once 'Domain51/Tool/Annotation/Value.php';

class Domain51_Tool_Annotation_ValueTest extends UnitTestCase
{
	public function testHasReadOnlyNamePropertyWhichIsSetAsFirstParameterOfConstructor()
	{
		$value = new Domain51_Tool_Annotation_Value('is');
		$this->assertEqual('is', $value->name);
		
		try {
			$value->name = 'something else';
			$this->fail('Exception not caught');
		} catch (Domain51_Tool_Annotation_Value_Exception $e) {
			$this->pass('exception caught');
		}
	}
	
	public function testHasReadOnlyParamsArrayPropertyAsSecondParameter()
	{
		$value = new Domain51_Tool_Annotation_Value('is', array());
		$this->assertEqual(array(), $value->params);
		unset($value);
		
		$array = array('Hello World', 'random' => rand(10, 20));
		$value = new Domain51_Tool_Annotation_Value('is', $array);
		$this->assertEqual($array, $value->params);
	}
	
	public function testThrowsExceptionOnNoneStringFirstParameter()
	{
		try {
			new Domain51_Tool_Annotation_Value(1);
			$this->fail('exception not caught');
		} catch (Domain51_Tool_Annotation_Value_Exception $e) {
			$this->pass('exception caught');
			$this->assertEqual('non-string provided for name at construct', $e->getMessage());
		}
		
		try {
			new Domain51_Tool_Annotation_Value(array());
			$this->fail('exception not caught');
		} catch (Domain51_Tool_Annotation_Value_Exception $e) {
			$this->pass('exception caught');
			$this->assertEqual('non-string provided for name at construct', $e->getMessage());
		}
		
		try {
			new Domain51_Tool_Annotation_Value(123.321);
			$this->fail('exception not caught');
		} catch (Domain51_Tool_Annotation_Value_Exception $e) {
			$this->pass('exception caught');
			$this->assertEqual('non-string provided for name at construct', $e->getMessage());
		}
		
		try {
			new Domain51_Tool_Annotation_Value(true);
			$this->fail('exception not caught');
		} catch (Domain51_Tool_Annotation_Value_Exception $e) {
			$this->pass('exception caught');
			$this->assertEqual('non-string provided for name at construct', $e->getMessage());
		}
		
		try {
			new Domain51_Tool_Annotation_Value($this);
			$this->fail('exception not caught');
		} catch (Domain51_Tool_Annotation_Value_Exception $e) {
			$this->pass('exception caught');
			$this->assertEqual('non-string provided for name at construct', $e->getMessage());
		}
	}
	
	public function testOnlyTakesAnOptionalArrayForSecondParamter()
	{
		$refl = new ReflectionClass('Domain51_Tool_Annotation_Value');
		$constructor = $refl->getConstructor();
		$params = $constructor->getParameters();
		
		$secondParam = $params[1];
		$this->assertTrue($secondParam->isArray());
		$this->assertTrue($secondParam->isOptional());
	}
}