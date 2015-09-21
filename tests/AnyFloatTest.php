<?php


class AnyFloatTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider floatDataProviderPassed
     */
    public function testAnyFloatPassed($actual, $options = [])
    {
        $expected = new \AnyJsonTester\Types\AnyFloat($options);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function floatDataProviderPassed()
    {
        return [
            ['5.5'],
            ['5.5', ['min' => 4.0]],
            ['5.5', ['max' => 6.0]],
            ['5.5', ['min' => 4.0, 'max' => 6.0]],
            ['5.5', ['min' => 4.0, 'max' => 6.0, 'precision' => 1]],
            [null, ['nullable' => true]],
        ];
    }

    /**
     * @dataProvider floatDataProviderFailed
     */
    public function testAnyFloatFailed($actual,  $options = [])
    {
        $expected = new \AnyJsonTester\Types\AnyFloat($options);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function floatDataProviderFailed()
    {
        return [
            ['3.0', ['min' => 4.0, 'max' => 6.0]],
            ['7.0', ['min' => 4.0, 'max' => 6.0]],
            ['5.50', ['min' => 4.0, 'max' => 6.0, 'precision' => 3]],
            ['strig', ['min' => 4.0, 'max' => 6.0]],
            [null, ['nullable' => false]],
        ];
    }

}
