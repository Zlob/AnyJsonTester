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
    public function seeJsonLike($expected, $negate = false )
    {
        $method = $negate ? 'assertFalse' : 'assertTrue';
        $actual = json_decode($this->response->getContent(), true);
        $checkResult = $expected->check($actual);
        $this->$method( $checkResult['passed'], $checkResult['message'] );
        return $this;
    }

}

