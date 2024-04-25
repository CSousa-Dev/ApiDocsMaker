<?php
namespace Test\Unit;

use PHPUnit\Framework\TestCase;
use DocsMaker\Attributes\Method;
use PHPUnit\Framework\Attributes\DataProvider;
use DocsMaker\Exceptions\InvalidMethodException;

class MethodTest extends TestCase
{

    #[DataProvider('validsMethodsName')]
    public function testValidMethod($method)
    {
        $method = new Method('GET');
        $this->assertEquals('GET', $method);
    }

    public function testInvalidMethod()
    {
        $this->expectException(InvalidMethodException::class);
        $this->expectExceptionMessage("An HTTP method must be a valid method among 'GET', 'POST', 'PUT', 'DELETE', 'PATCH'.");

        new Method('INVALID');
    }

    
    public static function validsMethodsName()
    {
        return [
            "Get"       =>  ['GET'],
            "Post"      =>  ['POST'],
            "Put"       =>  ['PUT'],
            "Delete"    =>  ['DELETE'],
            "Patch"     =>  ['PATCH'],
        ];
    }
}