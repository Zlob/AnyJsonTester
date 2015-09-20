<?php


class AnyStringTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider StringDataProviderPassed
     */
    public function testAnyStringPassed($actual, $min = null, $max = null, $regex = null, $nullable = false)
    {
        $expected = new \AnyJsonTester\Types\AnyString($min, $max, $regex, $nullable);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function StringDataProviderPassed()
    {
        return [
            ['string'],
            ['string', 2],
            ['string', null, 10],
            ['string', 2, 10],
            [null, null, null, null, true],
            ['string', null, null, '/rin/'],
        ];
    }

    /**
     * @dataProvider StringDataProviderFailed
     */
    public function testAnyStringFailed($actual, $min = null, $max = null, $regex = null, $nullable = false)
    {
        $expected = new \AnyJsonTester\Types\AnyString($min, $max, $regex, $nullable);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function StringDataProviderFailed()
    {
        return [
            [null, null, null, null, false],
            ['', 2],
            ['stringstring', null, 10],
            ['string', null, null, '/gring/'],
        ];
    }

}