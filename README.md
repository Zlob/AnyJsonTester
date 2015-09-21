# AnyJsonTester [![Build Status](https://travis-ci.org/Zlob/AnyJsonTester.svg?branch=master)](https://travis-ci.org/Zlob/AnyJsonTester) [![Latest Stable Version](https://poser.pugx.org/zlob/any-json-tester/v/stable)](https://packagist.org/packages/zlob/any-json-tester) [![Total Downloads](https://poser.pugx.org/zlob/any-json-tester/downloads)](https://packagist.org/packages/zlob/any-json-tester) [![License](https://poser.pugx.org/zlob/any-json-tester/license)](https://packagist.org/packages/zlob/any-json-tester)
Trait for PhpUnit, that helps you to test JSON with changeable values, like timestamps, count etc.
All you need - is to define structure of JSON with set of helper classes

## Installation
via composer 
composer require zlob/any-json-tester

## Example
Lets test JSON like 
```json
{
      "id"       : "1",
      "author"   : "Zlob",
      "project"  : "AnyJsonTester",
      "date"     : "21-09-2015",
      "rating"   : "9.9",
      "url"      : "https://github.com/Zlob/AnyJsonTester",
      "comments" : [
        {
          "text" : "awesome",
          "like" : "true"
        },
        {
          "text" : "Very good",
          "like" : "true"
        }
      ]
  }'
```

```
<?php

    //import classes
    use AnyJsonTester\Types\AnyArray;
    use AnyJsonTester\Types\AnyBoolean;
    use AnyJsonTester\Types\AnyDateTime;
    use AnyJsonTester\Types\AnyFloat;
    use AnyJsonTester\Types\AnyInteger;
    use AnyJsonTester\Types\AnyObject;
    use AnyJsonTester\Types\AnyString;

    class ExampleTest extends PHPUnit_Framework_TestCase
    {
        //use AnyJsonTester trait
        use \AnyJsonTester\AnyJsonTester;

        public function testSeeJsonLikeSimple()
        {
            //JSON, that we wont to test
            $JSON = '{
                          "id"       : "1",
                          "author"   : "Zlob",
                          "project"  : "AnyJsonTester",
                          "date"     : "21-09-2015",
                          "rating"   : "9.9",
                          "url"      : "https://github.com/Zlob/AnyJsonTester",
                          "comments" : [
                            {
                              "text" : "awesome",
                              "like" : "true"
                            },
                            {
                              "text" : "Very good",
                              "like" : "true"
                            }
                          ]
                      }';
            
            //describe JSON schema
            $expectedJson = new AnyObject([
                    'id'       => new AnyInteger(),           // you can set restrictions for type, like min, max
                    'author'   => new AnyString(),            // string length or regex
                    'date'     => new AnyDateTime(),          // date period or format
                    'rating'   => new AnyFloat(),             // precision
                    'project'  => 'AnyJsonTester',            // or you can just set explicit value
                                                              // or skip some fields, that you don`t wont to test
                    'comments' => new AnyArray(new AnyObject( //you can test array of objects, set min and max array length
                            [
                                'text' => new AnyString(),
                                'like' => new AnyBoolean()    //test boolean variables
                            ]
                        )
                    )
                ]
            );
            
            //call seeJsonLike function to test JSON against schema
            static::seeJsonLike($JSON, $expectedJson, false);
        }
    }
```

## Some sugar for Laravel 5.1
In my favorite framework, you can use AnyJsonTesterLaravel trait instead of AnyJsonTestertrait, so you can chain seeJsonLike method with request metods, like 
```
$this->post('/user', ['name' => 'Sally'])
     ->seeJsonLike( new AnyObject( [ 'name' => AnyJsonString() ] ) );
```
## License

MIT - [Zlob](https://github.com/zlob)
