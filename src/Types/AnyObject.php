<?php
/**
 * Created by PhpStorm.
 * User: Zloblin
 * Date: 18.09.2015
 * Time: 15:16
 */

namespace AnyJsonTester\Types;


class AnyObject implements AbstractType
{
    private $hasFields;
    private $hasNoFields;
    private $strictMode;
    private $nullable;

    public function __construct(array $hasFields = [], array $hasNoFields = [], $strictMode = false, $nullable = false)
    {
        $this->hasFields = $hasFields;
        $this->hasNoFields = $hasNoFields;
        $this->strictMode = $strictMode;
        $this->nullable = $nullable;
    }

    public function check($actual)
    {
        $checkResult = ['passed' => true, 'message' => 'has value'];

        //check object is null
        if ($actual === null) {
            return $this->checkNullable($checkResult);
        }

        //check that array has fields
        $checkResult = $this->checkHasFields($actual, $checkResult);
        if (!$checkResult['passed']) {
            return $checkResult;
        }

        //check that array has  no fields
        $checkResult = $this->checkHasNoFields($actual, $checkResult);
        if (!$checkResult['passed']) {
            return $checkResult;
        }

        //check strict mode
        if ($this->strictMode) {
            $checkResult = $this->checkStrictMode($actual, $checkResult);
        }

        return $checkResult;
    }

    private function checkNullable($checkResult)
    {
        $checkResult['message'] = 'Object is null';
        if ($this->nullable) {
            $checkResult['passed'] = true;
        } else {
            $checkResult['passed'] = false;
        }
        return $checkResult;
    }

    private function checkHasFields($actual, $checkResult)
    {
        foreach ($this->hasFields as $expectedKey => $expectedValue) {
            if (array_key_exists($expectedKey, $actual)) {
                if (is_object($expectedValue)) {
                    $checkResult = $expectedValue->check($actual[$expectedKey]);
                    if (!$checkResult['passed']) {
                        break;
                    }
                } elseif ($actual[$expectedKey] !== $expectedValue) {
                    $checkResult['passed'] = false;
                    $checkResult['message'] = "Unable to find value '$expectedValue' within " . json_encode($actual);
                    break;
                }
            } else {
                $checkResult['passed'] = false;
                $checkResult['message'] = "Unable to find key '$expectedKey' within " . json_encode($actual);
                break;
            }
        }
        return $checkResult;
    }

    private function checkHasNoFields($actual, $checkResult)
    {
        foreach ($this->hasNoFields as $unexpected) {
            if (array_key_exists($unexpected, $actual)) {
                $checkResult['passed'] = false;
                $checkResult['message'] = "Array has unexpected key '$unexpected' within " . json_encode($actual);
                break;
            }
        }
        return $checkResult;
    }

    private function checkStrictMode($actual, $checkResult)
    {
        $diff = array_diff_key($actual, $this->hasFields);
        if (count($diff) !== 0) {
            $checkResult['passed'] = false;
            $checkResult['message'] = 'Object has keys ' . json_encode($diff);
        }
        return $checkResult;
    }
}