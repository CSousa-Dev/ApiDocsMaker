<?php 
namespace Test\Unit\ResponseYaml;

use ReflectionMethod;
use DocsMaker\Attributes\RequestBody;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use DocsMaker\Attributes\Response;
use DocsMaker\Attributes\Schema\Properties\PropArray;
use DocsMaker\Attributes\Schema\Properties\PropObject;
use DocsMaker\Attributes\Schema\Properties\PropString;
use DocsMaker\Attributes\Schema\Properties\PropInteger;

class CreateRequestBodyYamlTest extends TestCase
{
    #[RequestBody(
        description: "Some request body",
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
    public function testCreateYamlRequestBody()
    {
        $reflectionMethod = new ReflectionMethod($this, 'testCreateYamlRequestBody');
        $request = $reflectionMethod->getAttributes(RequestBody::class)[0]->newInstance();
        $array = $request->toArray();
        $yaml = Yaml::dump($array, 16, 2);
        file_put_contents(__DIR__ . '/RequestTest.yaml', $yaml);
        $this->assertEquals(
            preg_replace("/\r\n/", "\n", file_get_contents(__DIR__ . '/RequestExemple.yaml')),
            file_get_contents(__DIR__ . '/RequestTest.yaml')
        );
    }  
} 