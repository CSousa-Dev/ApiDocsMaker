<?php 
namespace Test\Unit\ResponseYaml;

use ReflectionMethod;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use DocsMaker\Attributes\Response;
use DocsMaker\Attributes\Schema\Properties\PropArray;
use DocsMaker\Attributes\Schema\Properties\PropObject;
use DocsMaker\Attributes\Schema\Properties\PropString;
use DocsMaker\Attributes\Schema\Properties\PropInteger;

class CreateResponseYamlTest extends TestCase
{

    #[Response(
        statusCode: 200,
        description: "Successful operation",
        contentType: "application/json",
        content: new PropObject([
            new PropInteger(name: 'id', format: 'int64', example: 100000),
            new PropArray(name: 'address', itemsType: 
                new PropObject(description: 'testes testosos', properties: [
                    new PropString(name: 'teste'),
                    new PropArray(name: 'teste2', itemsType: new PropString(
                        enum: ['teste', 'teste2']
                    )),
                    new PropString(name: 'reference', example: 'testes')
                ])
            ),
            new PropString(name: 'username')
        ])
    )]
    #[Response(
        statusCode: 400,
        description: 'Invalid ID supplied'
    )]
    public function testCreateYamlSchemaContainsAllProperties()
    {
        $reflectionMethod = new ReflectionMethod($this, 'testCreateYamlSchemaContainsAllProperties');
        $status200 = new Response(...$reflectionMethod->getAttributes(Response::class)[0]->getArguments());
        $status400 = new Response(...$reflectionMethod->getAttributes(Response::class)[1]->getArguments());
        
        $array = [
            $status200->getCode() => $status200->toArray(),
            $status400->getCode() => $status400->toArray()
        ];

        $yaml = Yaml::dump($array, 16, 2);
        file_put_contents(__DIR__ . '/ResponseTest.yaml', $yaml);
        $this->assertEquals(
            preg_replace("/\r\n/", "\n", file_get_contents(__DIR__ . '/ResponseExemple.yaml')),
            file_get_contents(__DIR__ . '/ResponseTest.yaml')
        );
    }

    // #[Response(
    //     statusCode: 200,
    //     description: "Successful operation",
    //     contentType: "application/json",
    //     content: 
    // )]
    // public function testResponsesUsingRef()
    // {
    //     $reflectionMethod = new ReflectionMethod($this, 'testResponsesUsingRef');
    //     $response = $reflectionMethod->getAttributes(Response::class)[0]->newInstance();
        
    //     $array = $response->toArray();
        
    //     $this->assertContains('reftest', $array['content']['application/json']['$ref']);
    // }
       
} 