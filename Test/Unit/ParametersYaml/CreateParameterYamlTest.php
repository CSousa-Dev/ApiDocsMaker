<?php 
namespace Test\Unit\ParametersYaml;

use DocsMaker\Attributes\Parameter;
use ReflectionMethod;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use DocsMaker\Attributes\Schema\Properties\PropInteger;

class CreateParameterYamlTest extends TestCase
{
    #[Parameter(
        name: 'petId',
        in: 'path',
        description: 'ID of pet to return',
        required: true,
        schema: new PropInteger(name: 'id', format: 'int64')
    )]
    public function testCreateYamlParameter()
    {
        $reflectionMethod = new ReflectionMethod($this, 'testCreateYamlParameter');
        $param = $reflectionMethod->getAttributes(Parameter::class)[0]->newInstance();

        $teste =[ "parameters" => [json_decode(json_encode($param->toArray()), true)]];

        $yaml = Yaml::dump($teste, 16, 2,);
        file_put_contents(__DIR__ . '/ParameterTest.yaml', $yaml);
        $this->assertEquals(
            preg_replace("/\r\n/", "\n", file_get_contents(__DIR__ . '/ParameterExample.yaml')),
            file_get_contents(__DIR__ . '/ParameterTest.yaml')
        );
    }  
} 