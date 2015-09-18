<?php
/**
 * Created by PhpStorm.
 * User: Zloblin
 * Date: 18.09.2015
 * Time: 15:16
 */

namespace AnyJsonTester\Types;


class AnyInteger implements AbstractType{
    private $min;
    private $max;
    private $nullable;

    public function __construct($min = null, $max = null, $nullable = false)
    {
        $this->min = $min;
        $this->max = $max;
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
        } elseif (!filter_var($value, FILTER_VALIDATE_INT)) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "value $value is not integer";
        } elseif ($this->min && $value < $this->min) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "value $value is less then minimum value $this->min";
        } elseif ($this->max && $value > $this->max) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "value $value is greater then maximum value $this->max";
        }
        return $checkResult;
    }
}