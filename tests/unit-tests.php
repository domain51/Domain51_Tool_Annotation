<?php

require_once dirname(__FILE__) . '/bootstrap.php';

class Domain51_Tool_AnnotationTestSuite extends TestSuite
{
    public function __construct() 
    {
        $this->addTestFile('Domain51/Tool/Annotation/CollectionTest.php');
        $this->addTestFile('Domain51/Tool/Annotation/ParamsHelper/AsUMLMethodArgumentsTest.php');
        $this->addTestFile('Domain51/Tool/Annotation/ParamsHelper/ExplodeOnWhitespaceTest.php');
        $this->addTestFile('Domain51/Tool/Annotation/ParserTest.php');
        $this->addTestFile('Domain51/Tool/Annotation/ValueTest.php');
    }
}
