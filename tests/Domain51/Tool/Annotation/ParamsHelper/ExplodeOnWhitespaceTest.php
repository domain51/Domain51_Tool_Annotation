<?php

require_once dirname(__FILE__) . '/../../../../bootstrap.php';
require_once 'Domain51/Tool/Annotation/ParamsHelper/ExplodeOnWhitespace.php';

class Domain51_Tool_Annotation_ParamsHelper_ExplodeOnWhitespaceTest extends UnitTestCase
{
    public function testSimplyExplodesOnWhitespaceAndReturnsTheArray()
    {
        $random = rand(100, 200);
        $str = "one two three {$random}";
        
        $exploder = new Domain51_Tool_Annotation_ParamsHelper_ExplodeOnWhitespace();
        $array = $exploder->parse($str);
        
        $this->assertEqual(4, count($array));
        $this->assertEqual(
            array('one', 'two', 'three', $random),
            $array
        );
    }
}
