<?php

class AnyArrayTest extends PHPUnit_Framework_TestCase
{

    public function testAnyArrayOfInteger()
    {
        $actual = [0, 1, 4, 7];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyInteger());
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayOfString()
    {
        $actual = ['some', 'string'];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyString());
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayOfBoolean()
    {
        $actual = ['true', 'false', 'true'];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyBoolean());
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayOfDateTime()
    {
        $actual = ['1987-12-14', '2015-08-15'];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyDateTime());
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyArrayOfFloat()
    {
        $actual = [10.5, 11.3];
        $expected = new \AnyJsonTester\Types\AnyArray(new \AnyJsonTester\Types\AnyFloat());
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

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