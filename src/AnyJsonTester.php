<?php

namespace AnyJsonTester;


trait AnyJsonTester {
    public function seeJsonLike($actual, $expected, $negate = false )
    {
        $method = $negate ? 'assertFalse' : 'assertTrue';
        $actual = json_decode($actual, true);
        $checkResult = $expected->check($actual);
        $this->$method( $checkResult['passed'], $checkResult['message'] );
        return $this;
    }
}