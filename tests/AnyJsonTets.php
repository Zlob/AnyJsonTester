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
        static::seeJsonLike($actualString, $expectedArray, true); //todo unable find key + unable find value
    }

    /**
     * @dataProvider integerDataProvider
     */
    public function testSeeJsonLikeInteger($actualArray, $min, $max, $nullable, $negate )
    {
        $actualString = json_encode($actualArray, true);
        $expectedArray = ['field' => new \AnyJsonTester\Types\AnyInteger($min, $max, $nullable)];
        static::seeJsonLike($actualString, $expectedArray, $negate);
    }

    public function integerDataProvider()
    {
        return [
            [['field' => '5'], 4, 6, false, false],
            [['field' => null], 4, 6, true, false],
            [['field' => '3'], 4, 6, false, true],
            [['field' => '7'], 4, 6, false, true],
            [['field' => 'string'], 4, 6, false, true],
        ];
    }

    /**
     * @dataProvider floatDataProvider
     */
    public function testSeeJsonLikeFloat($actualArray, $negate, $min = null, $max = null, $precision = null, $nullable = false)
    {
        $actualString = json_encode($actualArray, true);
        $expectedArray = ['field' => new \AnyJsonTester\Types\AnyFloat($min, $max, $precision, $nullable)];
        static::seeJsonLike($actualString, $expectedArray, $negate);
    }

    public function floatDataProvider()
    {
        return [
            [['field' => '5.5'], false],
            [['field' => '5.5'], false, 4.0],
            [['field' => '5.5'], false, null, 6.0],
            [['field' => '5.5'], false, 4.0, 6.0],
            [['field' => '5.5'], false, 4.0, 6.0, 1],
            [['field' => '3.0'], true, 4.0, 6.0],
            [['field' => '7.0'], true, 4.0, 6.0],
            [['field' => '5.50'], true, 4.0, 6.0, 3],
            [['field' => 'string'], true, 4.0, 6.0],
            [['field' => null], false, 4.0, 6.0, null, true],
        ];
    }

    /**
     * @dataProvider booleanDataProvider
     */
    public function testSeeJsonLikeBoolean($actualArray, $negate,  $strict = false, $nullable = false )
    {
        $actualString = json_encode($actualArray, true);
        $expectedArray = ['field' => new \AnyJsonTester\Types\AnyBoolean( $strict, $nullable)];
        static::seeJsonLike($actualString, $expectedArray, $negate);

    }

    public function booleanDataProvider()
    {
        return [

            [['field' => '0'], false],
            [['field' => '0'], true, true],

            [['field' => 'false'], false],
            [['field' => 'false'], false, true],

            [['field' => 'off'], false],
            [['field' => 'off'], true, true],

            [['field' => 'no'], false],
            [['field' => 'no'], true, true],

            [['field' => '1'], false],
            [['field' => '1'], true, true, ],

            [['field' => 'true'], false],
            [['field' => 'true'], false, true],

            [['field' => 'on'], false],
            [['field' => 'on'], true, true],

            [['field' => 'yes'], false],
            [['field' => 'yes'], true, true],

            [['field' => null], false, false, true],
            [['field' => null], true, false, false],
            [['field' => null], true, true, false],
        ];
    }

    /**
     * @dataProvider stringDataProvider
     */
    public function testSeeJsonLikeString($actualArray, $negate, $min = false, $max = false, $regexp = null, $nullable = false)
    {
        $actualString = json_encode($actualArray, true);
        $expectedArray = ['field' => new \AnyJsonTester\Types\AnyString( $min, $max, $regexp, $nullable)];
        static::seeJsonLike($actualString, $expectedArray, $negate);

    }

    public function stringDataProvider()
    {
        return [
            [['field' => 'string'], false],
            [['field' => 'string'], false, 2],
            [['field' => 'string'], false, null, 10],
            [['field' => 'string'], false, 2, 10],
            [['field' => null], false, null, null, null, true],
            [['field' => 'string'], false, null, null, '/rin/'],
            [['field' => null], true, null, null, null, false],
            [['field' => ''], true, 2],
            [['field' => 'stringstring'], true, null, 10],
            [['field' => 'string'], true, null, null, '/gring/'],
        ];
    }


}