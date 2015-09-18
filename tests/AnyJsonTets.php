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
    public function testSeeJsonLikeFloat($actualArray, $min, $max, $precision, $nullable, $negate)
    {
        $actualString = json_encode($actualArray, true);
        $expectedArray = ['field' => new \AnyJsonTester\Types\AnyFloat($min, $max, $precision, $nullable)];
        static::seeJsonLike($actualString, $expectedArray, $negate);
    }

    public function floatDataProvider()
    {
        return [
            [['field' => '5.5'], 4.0, 6.0, null, false, false],
            [['field' => '5.5'], 4.0, 6.0, 1, false, false],
            [['field' => null], 4.0, 6.0, null, true, false],
            [['field' => '3.0'], 4.0, 6.0, null, false, true],
            [['field' => '7.0'], 4.0, 6.0, null, false, true],
            [['field' => '5.50'], 4.0, 6.0, 3, false, true],
            [['field' => 'string'], 4.0, 6.0, null, false, true],
        ];
    }

    /**
     * @dataProvider booleanDataProvider
     */
    public function testSeeJsonLikeBoolean($actualArray, $strict, $nullable, $negate)
    {
        $actualString = json_encode($actualArray, true);
        $expectedArray = ['field' => new \AnyJsonTester\Types\AnyBoolean( $strict, $nullable)];
        static::seeJsonLike($actualString, $expectedArray, $negate);

    }

    public function booleanDataProvider()
    {
        return [

            [['field' => '0'], null, null, false],
            [['field' => '0'], true, null, true],

            [['field' => 'false'], null, null, false],
            [['field' => 'false'], true, null, false],

            [['field' => 'off'], null, null, false],
            [['field' => 'off'], true, null, true],

            [['field' => 'no'], null, null, false],
            [['field' => 'no'], true, null, true],

            [['field' => '1'], null, null, false],
            [['field' => '1'], true, null, true],

            [['field' => 'true'], null, null, false],
            [['field' => 'true'], true, null, false],

            [['field' => 'on'], null, null, false],
            [['field' => 'on'], true, null, true],

            [['field' => 'yes'], null, null, false],
            [['field' => 'yes'], true, null, true],

            [['field' => null], null, true, false],
            [['field' => null], null, false, true],
            [['field' => null], true, false, true],
        ];
    }


}