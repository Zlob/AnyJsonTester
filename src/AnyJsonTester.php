<?php

namespace AnyJsonTester;


trait AnyJsonTester {
    public function seeJsonLike($actual, $expected, $negate = false )
    {
        $method = $negate ? 'assertFalse' : 'assertTrue';
        $actual = json_decode($actual, true);
        foreach($expected as $key => $value){
            if(array_key_exists($key, $actual)){
                if(is_object($value)){
                    $value->check($actual[$key], $negate);
                }
                else{
                    $this->$method($actual[$key] === $value, "Unable to find value '$value' within ".json_encode($actual));
                }
            }
            else{
                $this->$method(false, "Unable to find key '$key' within ".json_encode($actual));
            }
        }
        return $this;
    }
}