<?php

namespace AnyJsonTester\Types;

/**
 * Class AnyInteger
 * @package AnyJsonTester\Types
 */
class AnyInteger implements AbstractType{

    /**
     * minimum integer value, null if no restrictions
     * @var null | int
     */
    private $min;

    /**
     * maximum integer value, null if no restrictions
     * @var null | int
     */
    private $max;

    /**
     * defines if value can be null
     * @var bool
     */
    private $nullable;

    /**
     * @param null | int $min - minimum integer value, null if no restrictions
     * @param null | int $max - maximum integer value, null if no restrictions
     * @param bool $nullable - defines if value can be null
     */
    public function __construct($min = null, $max = null, $nullable = false)
    {
        $this->min = $min;
        $this->max = $max;
        $this->nullable = $nullable;
    }

    /**
     * Check if value matches restrictions
     * @param $value
     * @return array
     */
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