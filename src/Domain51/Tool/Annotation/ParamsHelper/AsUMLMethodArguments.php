<?php

require_once 'Domain51/Tool/Annotation/ParamsHelper.php';

/**
 * @todo implement parsing of types and check validity of supplied arguments
 */
class Domain51_Tool_Annotation_ParamsHelper_AsUMLMethodArguments
    implements Domain51_Tool_Annotation_ParamsHelper
{
    public function parse($string)
    {
        if (substr($string, 0, 1) == '(') {
            $string = substr($string, 1);
        }
        if (substr($string, -1) == ')') {
            $string = substr($string, 0, -1);
        }
        
        $return = array();
        
        $values = explode(',', $string);
        foreach ($values as $value) {
            $param = explode('=', $value);
            $return[trim($param[0])] = trim($param[1]);
        }
        
        return $return;
    }
}