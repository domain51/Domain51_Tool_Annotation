<?php

require_once dirname(__FILE__) . '/../../../bootstrap.php';
require_once 'Domain51/Tool/Annotation/Collection.php';
if (!class_exists('MockDomain51_Tool_Annotation_Value')) {
	Mock::generate('Domain51_Tool_Annotation_Value');
}

class Domain51_Tool_Annotation_CollectionTest extends UnitTestCase
{
	public function testCanBeAddedTo()
	{
		$collection = new Domain51_Tool_Annotation_Collection();
		$this->assertEqual(0, $collection->count());
		$collection->add(new MockDomain51_Tool_Annotation_Value());
		$this->assertEqual(1, $collection->count());
	}
	
	public function testHasTellsWhetherTheCollectionContainsASpecificAnnotation()
	{
		$annotation = new MockDomain51_Tool_Annotation_Value();
		$annotation->setReturnValue('__get', 'known', array('name'));
		$collection = new Domain51_Tool_Annotation_Collection();
		$collection->add($annotation);
		
		$this->assertTrue($collection->has('known'));
		$this->assertFalse($collection->has('unknown'));
	}
	
	public function testCanReturnANewCollectionWithFilteredResults()
	{
		$is = new Domain51_Tool_Annotation_Value('is');
		$isNot = new Domain51_Tool_Annotation_Value('isNot');
		
		$collection = new Domain51_Tool_Annotation_Collection();
		$collection->add($is);
		$collection->add($isNot);
		
		$this->assertEqual(2, $collection->count(), 'sanity check');
		$this->assertTrue($collection->has('is'), 'sanity check');
		$this->assertTrue($collection->has('isNot'), 'sanity check');
		
		$isCollection = $collection->filter('is');
		$this->assertEqual(1, $isCollection->count());
		$this->assertTrue($isCollection->has('is'));
		$this->assertFalse($isCollection->has('isNot'));
		
		$isNotCollection = $collection->filter('isNot');
		$this->assertEqual(1, $isNotCollection->count());
		$this->assertFalse($isNotCollection->has('is'));
		$this->assertTrue($isNotCollection->has('isNot'));
	}
	
	public function testCanReturnANewCollectionWithMultipleFilteredResults()
	{
		$is = new Domain51_Tool_Annotation_Value('is');
		$isNot = new Domain51_Tool_Annotation_Value('isNot');
		
		$collection = new Domain51_Tool_Annotation_Collection();
		$collection->add($is);
		$collection->add($isNot);
		
		$this->assertEqual(2, $collection->count(), 'sanity check');
		$this->assertTrue($collection->has('is'), 'sanity check');
		$this->assertTrue($collection->has('isNot'), 'sanity check');
		
		$newCollection = $collection->filter(array('is', 'isNot'));
		$this->assertEqual(2, $newCollection->count());
		$this->assertTrue($newCollection->has('is'));
		$this->assertTrue($newCollection->has('isNot'));
		
		$this->assertTrue(
			$collection == $newCollection,
			'$collection and $newCollection are equal in what they contains'
		);
		$this->assertTrue(
			$collection !== $newCollection,
			'$collection and $newCollection are not the exact same object'
		);
	}
	
	public function testCanFilterOutAnnotationsAsWell()
	{
		$is = new Domain51_Tool_Annotation_Value('is');
		$isNot = new Domain51_Tool_Annotation_Value('isNot');
		
		$collection = new Domain51_Tool_Annotation_Collection();
		$collection->add($is);
		$collection->add($isNot);
		
		$this->assertEqual(2, $collection->count(), 'sanity check');
		$this->assertTrue($collection->has('is'), 'sanity check');
		$this->assertTrue($collection->has('isNot'), 'sanity check');
		
		$isOutCollection = $collection->filterOut('is');
		$this->assertEqual(1, $isOutCollection->count());
		$this->assertFalse($isOutCollection->has('is'));
		$this->assertTrue($isOutCollection->has('isNot'));
		
		$isNotOutCollection = $collection->filterOut('isNot');
		$this->assertEqual(1, $isNotOutCollection->count());
		$this->assertTrue($isNotOutCollection->has('is'));
		$this->assertFalse($isNotOutCollection->has('isNot'));
	}
	
	public function testIsAnIterator()
	{
		$collection = new Domain51_Tool_Annotation_Collection();
		$this->assertIsA($collection, 'Iterator');
		
		$this->assertFalse($collection->valid());
		$this->assertNull($collection->key());
		$this->assertNull($collection->current());
		
		$is = new Domain51_Tool_Annotation_Value('is');
		$collection->add($is);
		$this->assertTrue($collection->valid());
		$this->assertEqual($collection->current(), $is);
		$this->assertIdentical($collection->key(), 0);
		
		$collection->next();
		$this->assertFalse($collection->valid());
		$this->assertNull($collection->current());
		$this->assertNull($collection->key());
		
		$collection->rewind();
		$this->assertTrue($collection->valid());
		$this->assertEqual($collection->current(), $is);
		$this->assertIdentical($collection->key(), 0);
	}
}