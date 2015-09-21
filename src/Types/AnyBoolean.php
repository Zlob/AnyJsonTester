<?php

namespace AnyJsonTester\Types;

/**
 * Class AnyBoolean
 * @package AnyJsonTester\Types
 */
class AnyBoolean implements AbstractType
{
    /**
     * if true - use strict mode - only 'true' and 'false' strings are boolean
     * @var bool
     */
    private $strictMode = false;

    /**
     * defines if value can be null
     * @var bool
     */
    private $nullable = false;

    /**
     * @param array $options
     * hash strictMode - bool, if true - only 'true' and 'false' strings are boolean
     * hash nullable - bool, if true - value can be null
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
        } elseif (!$this->checkIsBoolean($value)) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "value $value is not boolean";
        }
        return $checkResult;
    }

    /**
     * Check if value is boolean
     * @param $value
     * @return bool
     */
    private function checkIsBoolean($value)
    {
        if ($this->strictMode) {
            return $this->checkStrict($value);
        } else {
            return $this->checkNotStrict($value);
        }
    }

    /**
     * Check if value is boolean in strict mode
     * @param $value
     * @return bool
     */
    private function checkStrict($value)
    {
        if ($value === 'true' or $value === 'false') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check if value is boolean in non strict mode
     * @param $value
     * @return bool
     */
    private function checkNotStrict($value)
    {
        if (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null) {
            return true;
        } else {
            return false;
        }
    }

}