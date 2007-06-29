<?php

class Domain51_Tool_Annotation_ParamsHelper_ExplodeOnWhitespace
{
    public function parse($str)
    {
        return explode(' ', $str);
    }
}