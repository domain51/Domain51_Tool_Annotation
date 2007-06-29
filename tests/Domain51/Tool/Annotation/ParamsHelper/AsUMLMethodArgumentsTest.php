<?php

require_once dirname(__FILE__) . '/../../../../bootstrap.php';
require_once 'Domain51/Tool/Annotation/ParamsHelper/AsUMLMethodArguments.php';

class Domain51_Tool_Annotation_ParamsHelper_AsUMLMethodArgumentsTest extends UnitTestCase
{
    public function testParsesASimpleUMLMethodSignatureIntoAnArray()
    {
        $random = rand(100, 200);
        $string = "arg1=value, arg2={$random}";
        
        $helper = new Domain51_Tool_Annotation_ParamsHelper_AsUMLMethodArguments();
        $array = $helper->parse($string);
        $expected = array(
            'arg1' => 'value',
            'arg2' => $random,
        );
        $this->assertEqual($expected, $array);
    }
    
    public function testCanStripParenthesisOffOfString()
    {
        $random = rand(100, 200);
        $string = "(arg1=value, arg2={$random})";
        
        $helper = new Domain51_Tool_Annotation_ParamsHelper_AsUMLMethodArguments();
        $array = $helper->parse($string);
        $expected = array(
            'arg1' => 'value',
            'arg2' => $random,
        );
        $this->assertEqual($expected, $array);
    }
}