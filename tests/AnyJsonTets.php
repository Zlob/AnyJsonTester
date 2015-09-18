<?php


class AnyJsonTets extends PHPUnit_Framework_TestCase
{
    use \AnyJsonTester\AnyJsonTester;

    public function testSeeJsonLikeSimple()
    {
        $actualArray = ['field' => 'value'];
        $actualString = json_encode($actualArray, true);
        $expectedArray = $actualArray;
        static::seeJsonLike($actualString, $expectedArray, false);
    }

    public function testSeeJsonLikeSimpleNegate()
    {
        $actualArray = ['field' => 'value'];
        $actualString = json_encode($actualArray, true);
        $expectedArray = ['field' => 'faild value'];
        static::seeJsonLike($actualString, $expectedArray, true);
    }

    public function testSeeJsonLikeInteger()
    {
        $actualArray = ['field' => 5];
        $actualString = json_encode($actualArray, true);
        $expectedArray = ['field' => new \AnyJsonTester\Types\AnyInteger(4, 6)];
        static::seeJsonLike($actualString, $expectedArray);

        $actualArray = ['field' => null];
        $actualString = json_encode($actualArray, true);
        $expectedArray = ['field' => new \AnyJsonTester\Types\AnyInteger(4, 6, true)];
        static::seeJsonLike($actualString, $expectedArray);
    }



}