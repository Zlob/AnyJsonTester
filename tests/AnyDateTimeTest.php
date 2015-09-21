<?php


class AnyDateTimeTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider DateTimeDataProviderPassed
     */
    public function testAnyDateTimePassed($actual, $options = [])
    {
        $expected = new \AnyJsonTester\Types\AnyDateTime($options);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function DateTimeDataProviderPassed()
    {
        return [
            ['14-12-1987 14:52'],
            ['14-12-1987 14:52', ['min' => '01-01-1970']],
            ['14-12-1987 14:52', ['max' => '01-01-2025']],
            ['14-12-1987 14:52', ['min' => '01-01-1970', 'max' => '01-01-2025']],
            ['14-12-1987 14:52', ['format' => 'd-m-Y H:i']],
            [null, ['nullable' => true] ],
        ];
    }

    /**
     * @dataProvider DateTimeDataProviderFailed
     */
    public function testAnyDateTimeFailed($actual, $options = [])
    {
        $expected = new \AnyJsonTester\Types\AnyDateTime($options);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function DateTimeDataProviderFailed()
    {
        return [
            ['14-12-1987 14:52', ['min' => '01-01-1990']],
            ['14-12-1987 14:52', ['max' => '01-01-1986']],
            ['string'],
            ['14-12-1987 14:52', ['format' => 'd-m-y'] ],
            [null, ['nullable' => false]],
        ];
    }

}