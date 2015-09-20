<?php

namespace AnyJsonTester\Types;


class AnyArray implements AbstractType
{
    private $min;
    private $max;
    private $expectedElement;
    private $nullable;

    /**
     * @param AnyObject $expectedElement
     * @param null $min
     * @param null $max
     * @param bool $nullable
     */
    public function __construct(AnyObject $expectedElement, $min = null, $max = null, $nullable = false)
    {
        $this->min = $min;
        $this->max = $max;
        $this->expectedElement = $expectedElement;
        $this->nullable = $nullable;
    }

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