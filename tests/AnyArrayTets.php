<?php


class AnyArrayTest extends PHPUnit_Framework_TestCase
{

    public function testAnyArrayMinPassed()
    {
        $actual = [[], []];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject([]), 1);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayMinFailed()
    {
        $actual = [[], []];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject([]), 3);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayMaxPassed()
    {
        $actual = [[], []];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject([]), null, 3);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayMaxFailed()
    {
        $actual = [[], []];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject([]), null, 1);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayNullablePassed()
    {
        $actual = null;
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject([]), null, null, true);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayNullableFailed()
    {
        $actual = null;
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject([]), null, null, false);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayElementPassed()
    {
        $actual = [['field' => 'value']];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject(['field' => 'value']));
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayElementFailed()
    {
        $actual = [['field' => 'value']];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject(['field' => 'value2']));
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

}