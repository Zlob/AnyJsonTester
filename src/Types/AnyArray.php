<?php

namespace AnyJsonTester\Types;

/**
 * Class AnyArray
 * @package AnyJsonTester\Types
 */
class AnyArray implements AbstractType
{
    /**
     * minimum array length, null if no restrictions
     * @var null | int
     */
    private $min;

    /**
     * maximum array length, null if no restrictions
     * @var null | int
     */
    private $max;

    /**
     * defines array element structure
     * @var AnyObject
     */
    private $expectedElement;

    /**
     * defines if array can be null
     * @var bool
     */
    private $nullable = false;

    /**
     * @param AnyObject $expectedElement - defines array element structure
     * @param array $options
     * hash min - int, minimum array length
     * hash max - int, maximum array length
     * hash nullable - bool, defines if array can be null
     */
    public function __construct(AnyObject $expectedElement, array $options = [])
    {
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }
        $this->expectedElement = $expectedElement;
    }

    /**
     * Check if value matches restrictions
     * @param $value
     * @return array
     */
    public function check($value)
    {
        $checkResult = ['passed' => true, 'message' => 'has value'];
        if ($this->nullable && $value === null) {
            $checkResult['passed'] = true;
            $checkResult['message'] = "has value '$value'";
        } elseif (!$this->nullable && $value === null) {
            $checkResult['passed'] = false;
            $checkResult['message'] = 'value is null';
        } elseif (!is_array($value)) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "value $value is not array";
        } elseif ($this->min && count($value) < $this->min) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "array length is less then minimum value $this->min";
        } elseif ($this->max && count($value) > $this->max) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "array length is greater then maximum value $this->max";
        } else {
            $result = $this->checkArray($value, $checkResult);
            if (!$result['passed']) {
                $checkResult['passed'] = $result['passed'];
                $checkResult['message'] = $result['message'];
            }
        }
        return $checkResult;
    }

    /**
     * check that all array elements matches expectedElement
     * @param $value
     * @param $checkResult
     * @return array
     */
    private function checkArray($value, $checkResult)
    {
        foreach ($value as $index => $item) {
            $checkResult = $this->expectedElement->check($item);
            if (!$checkResult['passed']) {
                $checkResult['message'] .= " at index $index";
                break;
            }
        }
        return $checkResult;
    }
}