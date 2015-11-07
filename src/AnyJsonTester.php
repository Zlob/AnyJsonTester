<?php

namespace AnyJsonTester;


use AnyJsonTester\Types\AnyArray;
use AnyJsonTester\Types\AnyObject;

trait AnyJsonTester {

    /**
     * Assert that json matches pattern
     * @param string $actual
     * @param AnyObject|AnyArray $expected
     * @param bool $negate
     * @return $this
     */
    public function seeJsonLike($actual, $expected, $negate = false )
    {
        $actual = json_decode($actual, true);
        return $this->seeArrayLike($actual, $expected, $negate);
    }

    /**
     * Assert that array matches pattern
     * @param string $actual
     * @param AnyObject|AnyArray $expected
     * @param bool $negate
     * @return $this
     */
    public function seeArrayLike($actual, $expected, $negate = false)
    {
        $method = $negate ? 'assertFalse' : 'assertTrue';
        $checkResult = $expected->check($actual);
        $this->$method( $checkResult['passed'], $checkResult['message'] );
        return $this;
    }

}