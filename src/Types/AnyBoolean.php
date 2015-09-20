<?php
/**
 * Created by PhpStorm.
 * User: Zloblin
 * Date: 18.09.2015
 * Time: 15:16
 */

namespace AnyJsonTester\Types;


class AnyBoolean implements AbstractType
{
    private $strictMode;
    private $nullable;

    public function __construct($strictMode = false, $nullable = false)
    {
        $this->strictMode = $strictMode;
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
        } elseif (!$this->checkIsBoolean($value)) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "value $value is not boolean";
        }
        return $checkResult;
    }

    private function checkIsBoolean($value)
    {
        if ($this->strictMode) {
            return $this->checkStrict($value);
        } else {
            return $this->checkNotStrict($value);
        }
    }

    private function checkStrict($value)
    {
        if ($value === 'true' or $value === 'false') {
            return true;
        } else {
            return false;
        }
    }

    private function checkNotStrict($value)
    {
        if (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null) {
            return true;
        } else {
            return false;
        }
    }

}