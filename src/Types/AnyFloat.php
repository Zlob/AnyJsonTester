<?php

namespace AnyJsonTester\Types;

/**
 * Class AnyFloat
 * @package AnyJsonTester\Types
 */
class AnyFloat implements AbstractType
{
    /**
     * minimum float value, null if no restrictions
     * @var null | float
     */
    private $min;

    /**
     * minimum float value, null if no restrictions
     * @var null | float
     */
    private $max;

    /**
     * minimum float value, null if no restrictions
     * @var null | int
     */
    private $precision;

    /**
     * defines if value can be null
     * @var bool
     */
    private $nullable;

    /**
     * @param null | float $min - minimum float value, null if no restrictions
     * @param null | float $max - minimum float value, null if no restrictions
     * @param null | int $precision - minimum float value, null if no restrictions
     * @param bool $nullable - defines if value can be null
     */
    public function __construct($min = null, $max = null, $precision = null, $nullable = false)
    {
        $this->min = $min;
        $this->max = $max;
        $this->precision = $precision;
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
        } elseif (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "value $value is not float";
        } elseif ($this->min && $value < $this->min) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "value $value is less then minimum value $this->min";
        } elseif ($this->max && $value > $this->max) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "value $value is greater then maximum value $this->max";
        } elseif ($this->precision && $this->getPrecision($value) !== $this->precision) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "value $value precision is not equal to precision value $this->precision";
        }
        return $checkResult;
    }

    /**
     * Return precision of float
     * @param $value
     * @return int
     */
    private function getPrecision($value)
    {
        return strlen(substr(strrchr($value, "."), 1));
    }
}