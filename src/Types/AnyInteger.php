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
    private $nullable = false;

    /**
     * @param array $options
     * min - int, minimum integer value
     * max - int, maximum integer value
     * nullable - bool, defines if value can be null
     */
    function __construct( array $options = [] )
    {
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }
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