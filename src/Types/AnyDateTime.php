<?php
/**
 * Created by PhpStorm.
 * User: Zloblin
 * Date: 18.09.2015
 * Time: 15:16
 */

namespace AnyJsonTester\Types;


class AnyDateTime implements AbstractType{
    private $min;
    private $max;
    private $format;
    private $nullable;

    public function __construct($min = null, $max = null, $format = null, $nullable = false)
    {
        $this->min = $min;
        $this->max = $max;
        $this->format = $format;
        $this->nullable = $nullable;
    }

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