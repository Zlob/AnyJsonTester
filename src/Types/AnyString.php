<?php
/**
 * Created by PhpStorm.
 * User: Zloblin
 * Date: 18.09.2015
 * Time: 15:16
 */

namespace AnyJsonTester\Types;


/**
 * Class AnyString
 * @package AnyJsonTester\Types
 */
class AnyString implements AbstractType{

    /**
     * minimum string length, null if no restrictions
     * @var null | int
     */
    private $min;

    /**
     * maximum string length, null if no restrictions
     * @var null | int
     */
    private $max;

    /**
     * string regex pattern, null if no restrictions
     * @var null | string
     */
    private $regex;

    /**
     * defines if value can be null
     * @var bool
     */
    private $nullable = false;

    /**
     * defines possible string values
     * @var array
     */
    private $enum = [];

    /**
     * @param array $options
     * hash min - int, minimum string length
     * hash max - int, maximum string length
     * hash regex -  string,  regex pattern
     * hash nullable - boolean, defines if value can be null
     * hash enum - array, defines possible string values
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
        } elseif (!is_string($value) ) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "value '$value' is not string";
        } elseif ($this->min &&  strlen($value) < $this->min) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "string length  of '$value' is less then minimum length $this->min";
        } elseif ($this->max && strlen($value) > $this->max) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "string length  of '$value' is greater then maximum length $this->max";
        } elseif ($this->regex && preg_match($this->regex, $value) !== 1) {
            $checkResult['passed'] = false;
            $checkResult['message'] = "string '$value' does not matches to pattern '$this->regex'";
        } elseif (count($this->enum) > 0 && !in_array($value, $this->enum)) {
            $checkResult['passed'] = false;
            $enumAsString = implode(',', $this->enum);
            $checkResult['message'] = "string '$value' is not in set of possible values '$enumAsString'";
        }
        return $checkResult;
    }


}