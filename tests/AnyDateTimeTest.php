<?php


class AnyDateTimeTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider DateTimeDataProviderPassed
     */
    public function testAnyDateTimePassed($actual, $min = null, $max = null, $format = null, $nullable = false)
    {
        $expected = new \AnyJsonTester\Types\AnyDateTime($min, $max, $format, $nullable);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function DateTimeDataProviderPassed()
    {
        return [
            ['14-12-1987 14:52'],
            ['14-12-1987 14:52', '01-01-1970'],
            ['14-12-1987 14:52', null, '01-01-2025'],
            ['14-12-1987 14:52', '01-01-1970', '01-01-2025'],
            ['14-12-1987 14:52', null, null, 'd-m-Y H:i'],
            [null, null, null, null, true],
        ];
    }

    /**
     * @dataProvider DateTimeDataProviderFailed
     */
    public function testAnyDateTimeFailed($actual, $min = null, $max = null, $format = null, $nullable = false)
    {
        $expected = new \AnyJsonTester\Types\AnyDateTime($min, $max, $format, $nullable);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function DateTimeDataProviderFailed()
    {
        return [
            ['14-12-1987 14:52', '01-01-1990'],
            ['14-12-1987 14:52', null, '01-01-1986'],
            ['string'],
            ['14-12-1987 14:52', null, null, 'd-m-y'],
            [null, null, null, null, false],
        ];
    }

}