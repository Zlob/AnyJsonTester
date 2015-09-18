<?php
/**
 * Created by PhpStorm.
 * User: Zloblin
 * Date: 18.09.2015
 * Time: 15:16
 */

namespace AnyJsonTester\Types;


class AnyString implements AbstractType{
    private $min;
    private $max;
    private $regex;
    private $nullable;

    function __construct($min = null, $max = null, $regex = null, $nullable = false)
    {
        $this->min = $min;
        $this->max = $max;
        $this->regex = $regex;
        $this->nullable = $nullable;
    }

    public function check($value)
    {
        $checkResult = ['passed' => true, 'message' => "has value '$value'"];
        if ($this->nullable && $value === null) {
            $checkResult['passed'] = true;
            $checkResult['message'] = "has value '$value'";
        } elseif (!$this->nullable && $value === null) {
            $checkResult['passed'] = false;
            $checkResult['message'] = 'value is null';
        } elseif (!is_string($value) ) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "value '$value' is not string";
        } elseif ($this->min &&  strlen($value) < $this->min) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "string length  of '$value' is less then minimum length $this->min";
        } elseif ($this->max && strlen($value) > $this->max) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "string length  of '$value' is greater then maximum length $this->max";
        } elseif ($this->regex && preg_match($this->regex, $value) !== 1) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "string '$value' does not matches to pattern '$this->regex'";
        }
        return $checkResult;
    }


}