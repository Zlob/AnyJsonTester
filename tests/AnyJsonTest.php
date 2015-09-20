<?php


class AnyJsonTest extends PHPUnit_Framework_TestCase
{
    use \AnyJsonTester\AnyJsonTester;

    public function testSeeJsonLikeSimple()
    {
        $actualArray = ['field' => 'value'];
        $actualString = json_encode($actualArray, true);
        $expectedArray = $actualArray;
        static::seeJsonLike($actualString, new \AnyJsonTester\Types\AnyObject($expectedArray), false);
    }

    public function testSeeJsonLikeSimpleNegate()
    {
        $actualArray = ['field' => 'value'];
        $actualString = json_encode($actualArray, true);
        $expectedArray = ['field' => 'faild value'];
        static::seeJsonLike($actualString, new \AnyJsonTester\Types\AnyObject($expectedArray), true); //todo unable find key + unable find value
    }

}