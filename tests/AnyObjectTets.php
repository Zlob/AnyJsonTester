<?php


class AnyObjectTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider hasFieldsPassedDataProvider
     */
    public function testAnyObjectHasFieldsPassed($actual, $expected)
    {
        $expected = new \AnyJsonTester\Types\AnyObject($expected);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }


    public function hasFieldsPassedDataProvider()
    {
        return [
            [['field' => 'value'], ['field' => 'value']],
            [['field' => 'value'], ['field' => new \AnyJsonTester\Types\AnyString()]],
        ];
    }

    /**
     * @dataProvider hasFieldsFailedDataProvider
     */
    public function testAnyObjectHasFieldsFailed($actual, $expected)
    {
        $expected = new \AnyJsonTester\Types\AnyObject($expected);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }


    public function hasFieldsFailedDataProvider()
    {
        return [
            [['field' => 'value'], ['unknownField' => 'value']],
            [['field' => 'value'], ['field' => 'unknownValue']],
            [['field' => 'value'], ['field' => new \AnyJsonTester\Types\AnyInteger()]],
        ];
    }

    /**
     * @dataProvider hasNoFieldsPassedDataProvider
     */
    public function testAnyObjectHasNoFieldsPassed($actual, $expected)
    {
        $expected = new \AnyJsonTester\Types\AnyObject([],$expected);
        $checkResult = $expected->check($actual);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }


    public function hasNoFieldsPassedDataProvider()
    {
        return [
            [['field' => 'value'], ['password']],
        ];
    }

    /**
     * @dataProvider hasNoFieldsFailedDataProvider
     */
    public function testAnyObjectHasNoFieldsFailed($actual, $expected)
    {
        $expected = new \AnyJsonTester\Types\AnyObject([],$expected);
        $checkResult = $expected->check($actual);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }


    public function hasNoFieldsFailedDataProvider()
    {
        return [
            [['field' => 'value'], ['field']],
        ];
    }

    public function testAnyObjectNullablePassed()
    {
        $expected = new \AnyJsonTester\Types\AnyObject([], [], false, true);
        $checkResult = $expected->check(null);
        static::assertTrue($checkResult['passed'], $checkResult['message']);
    }

    public function testAnyObjectNullableFailed()
    {
        $expected = new \AnyJsonTester\Types\AnyObject([], [], false, false);
        $checkResult = $expected->check(null);
        static::assertFalse($checkResult['passed'], $checkResult['message']);
    }

}