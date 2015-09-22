<?php


class AnyIntegerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider IntegerDataProviderPassed
     */
    public function testAnyIntegerPassed($actual, $options = [])
    {
        $expected = new \AnyJsonTester\Types\AnyInteger($options);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function IntegerDataProviderPassed()
    {
        return [
            ['0'],
            ['5'],
            ['5', ['min' => 4]],
            ['5', ['max' => 6]],
            ['5', ['min' => 4, 'max' => 6]],
            [null, ['nullable' => true]],
            [null, ['min' => 4, 'max' => 6, 'nullable' => true]],
        ];
    }

    /**
     * @dataProvider IntegerDataProviderFailed
     */
    public function testAnyIntegerFailed($actual, $options = [])
    {
        $expected = new \AnyJsonTester\Types\AnyInteger($options);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function IntegerDataProviderFailed()
    {
        return [
            ['3', ['min' => 4]],
            ['7', ['max' => 6]],
            ['string'],
            [null, ['nullable' => false]],
        ];
    }

}