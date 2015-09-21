<?php

namespace AnyJsonTester\Types;

/**
 * Class AnyDateTime
 * @package AnyJsonTester\Types
 */
class AnyDateTime implements AbstractType{

    /**
     * minimum date/time value, null if no restrictions
     * @var null | string
     */
    private $min;

    /**
     * maximum date/time value, null if no restrictions
     * @var null | string
     */
    private $max;

    /**
     * DateTime format
     * @var null | string
     */
    private $format;

    /**
     * defines if value can be null
     * @var bool
     */
    private $nullable = false;

    /**
     * @param array $options
     * hash min - string, minimum date/time value
     * hash max - string, maximum date/time value
     * hash format - string, DateTime format
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
        if ($value === null) {
            if ($this->nullable) {
                $checkResult['passed'] = true;
                $checkResult['message'] = "has value '$value'";
            } else {
                $checkResult['passed'] = false;
                $checkResult['message'] = 'value is null';
            }
        }
        else {
            try{
                $actualDateTime = new \DateTime($value);
                if($this->format && $value !== $actualDateTime->format($this->format)){
                    $checkResult['passed'] = false;
                    $formattedValue = $actualDateTime->format($this->format);
                    $checkResult['message'] = "value $value is not formatted as $this->format ($formattedValue)";
                } elseif ($this->min && $actualDateTime < new \DateTime($this->min)) {
                    $checkResult['passed'] = false;
                    $checkResult['message'] = "value $value is less then minimum value $this->min";
                } elseif ($this->max && $actualDateTime > new \DateTime($this->max)) {
                    $checkResult['passed'] = false;
                    $checkResult['message'] = "value $value is greater then maximum value $this->max";
                }
            }
            catch(\Exception $e){
                $checkResult['passed'] = false;
                $checkResult['message'] = "value $value is not a valid date";
                return $checkResult;
            }
        }
        return $checkResult;
    }
}