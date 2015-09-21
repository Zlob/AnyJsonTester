<?php


class AnyObjectTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider hasFieldsPassedDataProvider
     */
    public function testAnyObjectHasFieldsPassed($actual, $options)
    {
        $expected = new \AnyJsonTester\Types\AnyObject($options);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }


    public function hasFieldsPassedDataProvider()
    {
        return [
            [['field' => 'value'], ['hasFields' => ['field' => 'value']] ],
            [['field' => 'value'], ['hasFields' => ['field' => new \AnyJsonTester\Types\AnyString()]]],
        ];
    }

    /**
     * @dataProvider hasFieldsFailedDataProvider
     */
    public function testAnyObjectHasFieldsFailed($actual, $options)
    {
        $expected = new \AnyJsonTester\Types\AnyObject($options);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }


    public function hasFieldsFailedDataProvider()
    {
        return [
            [['field' => 'value'], ['hasFields' => ['unknownField' => 'value']]],
            [['field' => 'value'], ['hasFields' => ['field' => 'unknownValue']]],
            [['field' => 'value'], ['hasFields' => ['field' => new \AnyJsonTester\Types\AnyInteger()]]],
        ];
    }

    /**
     * @dataProvider hasNoFieldsPassedDataProvider
     */
    public function testAnyObjectHasNoFieldsPassed($actual, $options)
    {
        $expected = new \AnyJsonTester\Types\AnyObject($options);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }


    public function hasNoFieldsPassedDataProvider()
    {
        return [
            [['field' => 'value'], ['hasNoFields' => ['password']]],
        ];
    }

    /**
     * @dataProvider hasNoFieldsFailedDataProvider
     */
    public function testAnyObjectHasNoFieldsFailed($actual, $options)
    {
        $expected = new \AnyJsonTester\Types\AnyObject($options);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }


    public function hasNoFieldsFailedDataProvider()
    {
        return [
            [['field' => 'value'], ['hasFields' => ['field']]],
        ];
    }

    public function testAnyObjectNullablePassed()
    {
        $expected = new \AnyJsonTester\Types\AnyObject(['nullable' => true]);
        $checkResult = $expected->check(null);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyObjectNullableFailed()
    {
        $expected = new \AnyJsonTester\Types\AnyObject(['nullable' => false]);
        $checkResult = $expected->check(null);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

}