<?php


class AnyBooleanTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider booleanDataProviderPassed
     */
    public function testAnyBooleanPassed($actual, $strict = false, $nullable = false)
    {
        $expected = new \AnyJsonTester\Types\AnyBoolean($strict, $nullable);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function booleanDataProviderPassed()
    {
        return [
            ['0', false, false],
            ['1', false, false],

            ['off', false, false],
            ['on', false, false],

            ['no', false, false],
            ['yes', false, false],

            ['true', false, false],
            ['false', false, false],

            ['true', true, false],
            ['false', true, false],

            [null, false, true],
        ];
    }

    /**
     * @dataProvider booleanDataProviderFailed
     */
    public function testAnyBooleanFailed($actual, $strict = false, $nullable = false)
    {
        $expected = new \AnyJsonTester\Types\AnyBoolean($strict, $nullable);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function booleanDataProviderFailed()
    {
        return [
            ['0', true, false],
            ['1', true, false],

            ['off', true, false],
            ['on', true, false],

            ['no', true, false],
            ['yes', true, false],

            [null, false, false],
        ];
    }

}
