<?php

namespace AnyJsonTester;


use AnyJsonTester\Types\AnyArray;
use AnyJsonTester\Types\AnyObject;

trait AnyJsonTesterLaravel {

    /**
     * Assert that json matches pattern
     * @param AnyObject|AnyArray $expected
     * @param bool $negate
     * @return $this
     */
    public function seeJsonLike( $expected, $negate = false )
    {
        $actual = json_decode($this->response->getContent(), true);
        return $this->check($actual, $expected, $negate);
    }

    /**
     * Assert that array matches pattern
     * @param AnyObject|AnyArray $expected
     * @param bool $negate
     * @return $this
     */
    public function seeArrayLike( $expected, $negate = false )
    {
        $actual = $this->response->getContent();
        return $this->check($actual, $expected, $negate);
    }

    /**
     * Assert that data matches pattern
     * @param AnyObject|AnyArray $expected
     * @param bool $negate
     * @return $this
     */
    private function check( $actual, $expected, $negate = false )
    {
        $method = $negate ? 'assertFalse' : 'assertTrue';
        $checkResult = $expected->check($actual);
        $this->$method( $checkResult['passed'], $checkResult['message'] );
        return $this;
    }

}

