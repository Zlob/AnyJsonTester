<?php


class AnyIntegerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider IntegerDataProviderPassed
     */
    public function testAnyIntegerPassed($actual, $min = null, $max = null, $nullable = false)
    {
        $expected = new \AnyJsonTester\Types\AnyInteger($min, $max, $nullable);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function IntegerDataProviderPassed()
    {
        return [
            ['5'],
            ['5', 4],
            ['5', null, 6],
            ['5', 4, 6],
            [null, null, null, true],
            [null, 5, 6, true],
        ];
    }

    /**
     * @dataProvider IntegerDataProviderFailed
     */
    public function testAnyIntegerFailed($actual, $min = null, $max = null, $nullable = false)
    {
        $expected = new \AnyJsonTester\Types\AnyInteger($min, $max, $nullable);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function IntegerDataProviderFailed()
    {
        return [
            ['3', 4],
            ['7', null, 6],
            ['string', null, null],
            [null, null, null, false],
        ];
    }

}