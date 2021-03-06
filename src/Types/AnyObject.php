<?php
/**
 * Created by PhpStorm.
 * User: Zloblin
 * Date: 18.09.2015
 * Time: 15:16
 */

namespace AnyJsonTester\Types;


/**
 * Class AnyObject
 * @package AnyJsonTester\Types
 */
class AnyObject implements AbstractType
{
    /**
     * expected fields array
     * @var array
     */
    private $hasFields = [];

    /**
     * unexpected fields array
     * @var array
     */
    private $hasNoFields = [];

    /**
     * strict mode - if true, value must contain only fields, described in hasFields param
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
     * hash hasFields - array, expected fields array
     * hash hasNoFields - array, unexpected fields array
     * hash strictMode - bool, if true, value must contain only fields, described in hasFields param
     * hash nullable - bool, defines if value can be null
     */
    function __construct( array $options = [] )
    {
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Check if value matches restrictions
     * @param $actual
     * @return array
     */
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

    /**
     * check object is null
     * @param $checkResult
     * @return mixed
     */
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

    /**
     * check that array has fields
     * @param $actual
     * @param $checkResult
     * @return mixed
     */
    private function checkHasFields($actual, $checkResult)
    {
        foreach ($this->hasFields as $expectedKey => $expectedValue) {
            if (array_key_exists($expectedKey, $actual)) {
                if (is_object($expectedValue)) {
                    $checkResult = $expectedValue->check($actual[$expectedKey]);
                    if (!$checkResult['passed']) {
                        $checkResult['message'] .= " in key '$expectedKey'";
                        break;
                    }
                } elseif ($actual[$expectedKey] !== $expectedValue) {
                    $checkResult['passed'] = false;
                    $actualValue = $actual[$expectedKey];
                    $checkResult['message'] = "Actual value '$actualValue' does not match expected value '$expectedValue' in key '$expectedKey'";
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

    /**
     * check that array has  no fields
     * @param $actual
     * @param $checkResult
     * @return mixed
     */
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

    /**
     * check strict mode
     * @param $actual
     * @param $checkResult
     * @return mixed
     */
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