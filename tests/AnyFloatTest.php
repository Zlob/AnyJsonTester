<?php


class AnyFloatTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider floatDataProviderPassed
     */
    public function testAnyFloatPassed($actual, $min = null, $max = null, $precision = null, $nullable = false)
    {
        $expected = new \AnyJsonTester\Types\AnyFloat($min, $max, $precision, $nullable);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function floatDataProviderPassed()
    {
        return [
            ['5.5'],
            ['5.5', 4.0],
            ['5.5', null, 6.0],
            ['5.5', 4.0, 6.0],
            ['5.5', 4.0, 6.0, 1],
            [null, null, null, null, true],
        ];
    }

    /**
     * @dataProvider floatDataProviderFailed
     */
    public function testAnyFloatFailed($actual, $min = null, $max = null, $precision = null, $nullable = false)
    {
        $expected = new \AnyJsonTester\Types\AnyFloat($min, $max, $precision, $nullable);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function floatDataProviderFailed()
    {
        return [
            ['3.0', 4.0, 6.0],
            ['7.0', 4.0, 6.0],
            ['5.50', 4.0, 6.0, 3],
            ['strig', 4.0, 6.0],
            [null, null, null, null, false],
        ];
    }

}
