<?php

class AnyBooleanTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider booleanDataProviderPassed
     */
    public function testAnyBooleanPassed($actual, $options = [])
    {
        $expected = new \AnyJsonTester\Types\AnyBoolean($options);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function booleanDataProviderPassed()
    {
        return [
            ['0', ['strictMode' => false, 'nullable' => false ]],
            ['1', ['strictMode' => false, 'nullable' => false ]],

            ['off', ['strictMode' => false, 'nullable' => false ]],
            ['on', ['strictMode' => false, 'nullable' => false ]],

            ['no', ['strictMode' => false, 'nullable' => false ]],
            ['yes', ['strictMode' => false, 'nullable' => false ]],

            ['true', ['strictMode' => false, 'nullable' => false ]],
            ['false', ['strictMode' => false, 'nullable' => false ]],

            ['true', ['strictMode' => true, 'nullable' => false ]],
            ['false', ['strictMode' => true, 'nullable' => false ]],

            [null, ['strictMode' => false, 'nullable' => true ]],
        ];
    }

    /**
     * @dataProvider booleanDataProviderFailed
     */
    public function testAnyBooleanFailed($actual, $options = [])
    {
        $expected = new \AnyJsonTester\Types\AnyBoolean($options);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function booleanDataProviderFailed()
    {
        return [
            ['0', ['strictMode' => true, 'nullable' => false ]],
            ['1', ['strictMode' => true, 'nullable' => false ]],

            ['off', ['strictMode' => true, 'nullable' => false ]],
            ['on', ['strictMode' => true, 'nullable' => false ]],

            ['no', ['strictMode' => true, 'nullable' => false ]],
            ['yes', ['strictMode' => true, 'nullable' => false ]],

            [null, ['strictMode' => true, 'nullable' => false ]],
        ];
    }

}
