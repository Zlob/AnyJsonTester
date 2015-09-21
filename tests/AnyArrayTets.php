<?php

class AnyArrayTest extends PHPUnit_Framework_TestCase
{

    public function testAnyArrayMinPassed()
    {
        $actual = [[], []];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject(), ['min' => 1]);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayMinFailed()
    {
        $actual = [[], []];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject(), ['min' => 3]);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayMaxPassed()
    {
        $actual = [[], []];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject(), ['max' => 3]);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayMaxFailed()
    {
        $actual = [[], []];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject(), ['max' => 1]);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayNullablePassed()
    {
        $actual = null;
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject(), ['nullable' => true]);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayNullableFailed()
    {
        $actual = null;
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject(), ['nullable' => false]);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayElementPassed()
    {
        $actual = [['field' => 'value']];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject(['hasFields' => ['field' => 'value']]));
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayElementFailed()
    {
        $actual = [['field' => 'value']];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyObject(['hasFields' => ['field' => 'value2']]));
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

}