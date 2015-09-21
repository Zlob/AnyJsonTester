<?php


class AnyJsonTest extends PHPUnit_Framework_TestCase
{
    use \AnyJsonTester\AnyJsonTester;

    public function testSeeJsonLikePassed()
    {
        $actualArray = ['field' => 'value'];
        $actualString = json_encode($actualArray, true);
        $expectedArray = $actualArray;
        static::seeJsonLike($actualString, new \AnyJsonTester\Types\AnyObject(['hasFields' => $expectedArray]), false);
    }

    public function testSeeJsonLikeUnableFindValue()
    {
        $actualArray = ['field' => 'value'];
        $actualString = json_encode($actualArray, true);
        $expectedArray = ['field' => 'faild value'];
        static::seeJsonLike($actualString, new \AnyJsonTester\Types\AnyObject(['hasFields' => $expectedArray]), true);
    }


    public function testSeeJsonLikeUnableFindKey()
    {
        $actualArray = ['field' => 'value'];
        $actualString = json_encode($actualArray, true);
        $expectedArray = ['unknown field' => 'faild value'];
        static::seeJsonLike($actualString, new \AnyJsonTester\Types\AnyObject(['hasFields' => $expectedArray]), true);
    }


}