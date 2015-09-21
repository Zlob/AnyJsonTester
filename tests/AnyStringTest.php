<?php


class AnyStringTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider StringDataProviderPassed
     */
    public function testAnyStringPassed($actual, $options = [])
    {
        $expected = new \AnyJsonTester\Types\AnyString($options);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function StringDataProviderPassed()
    {
        return [
            ['string'],
            ['string', ['min' => 2]],
            ['string', ['max' => 10]],
            ['string', ['min' => 2, 'max' => 10]],
            [null, ['nullable' => true]],
            ['string', ['regex' => '/rin/']],
        ];
    }

    /**
     * @dataProvider StringDataProviderFailed
     */
    public function testAnyStringFailed($actual, $options = [])
    {
        $expected = new \AnyJsonTester\Types\AnyString($options);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

    public function StringDataProviderFailed()
    {
        return [
            [null],
            ['', ['min' => 2]],
            ['stringstring', ['max' => 10]],
            ['string', ['regex' => '/grin/']],
        ];
    }

}