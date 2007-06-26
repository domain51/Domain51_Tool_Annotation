<?php

require_once dirname(__FILE__) . '/../../../bootstrap.php';
require_once 'Domain51/Tool/Annotation/Parser.php';

class Domain51_Tool_Annontation_ParserTest extends UnitTestCase
{
	public function testReturnsACollectionOfAnnotationsAfterParsing()
	{
		$parser = new Domain51_Tool_Annotation_Parser();
		$list = $parser->parse('');
		
		$this->assertIsA($list, 'Domain51_Tool_Annotation_Collection');
		$this->assertEqual(0, $list->count());
		unset($list);
		
		$random = rand(10, 20);
		$str = <<<END
/**
 * @is String
 * @dummy
 * @table string_table
 * @isNot Length {$random} <
 */
END;
		$list = $parser->parse($str);
		$this->assertEqual(4, $list->count());
		
		$this->assertTrue($list->has('is'));
		$this->assertTrue($list->has('dummy'));
		$this->assertTrue($list->has('table'));
		$this->assertTrue($list->has('isNot'));
		
		$is = $list->filter('is')->current();
		$this->assertIsA($is, 'Domain51_Tool_Annotation_Value');
		$this->assertEqual($is->name, 'is');
		$this->assertEqual($is->params, array('String'));
		
		$dummy = $list->filter('dummy')->current();
		$this->assertIsA($dummy, 'Domain51_Tool_Annotation_Value');
		$this->assertEqual($dummy->name, 'dummy');
		$this->assertEqual($dummy->params, array());
		
		$table = $list->filter('table')->current();
		$this->assertIsA($table, 'Domain51_Tool_Annotation_Value');
		$this->assertEqual($table->name, 'table');
		$this->assertEqual($table->params, array('string_table'));
		
		$isNot = $list->filter('isNot')->current();
		$this->assertIsA($isNot, 'Domain51_Tool_Annotation_Value');
		$this->assertEqual($isNot->name, 'isNot');
		$this->assertEqual($isNot->params, array('Length', $random, '<'));
	}
}