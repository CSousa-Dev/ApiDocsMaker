<?php 
namespace Test\Unit\Components;

use ReflectionClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use DocsMaker\Attributes\Component\ComponentProp;
use Test\FakeApi\ValidsResources\JohnDoeResource;
use DocsMaker\Attributes\Component\ComponentSchema;
use Test\FakeApi\Api\Components\Schema as ClassWtithComponentSchema;
use DocsMaker\Exceptions\OnlyComponentClassesCanBeReferencedException;
use Test\FakeApi\Api\Components\AnotherSchema;

class SchemaComponentTest extends TestCase
{
    #[ComponentProp]
    private JohnDoeResource $propTest;
    
    public function testSetComponentPropsInComponentSchema()
    {
        $refClass = new ReflectionClass(ClassWtithComponentSchema::class);
        $componentSchemaAttribute = $refClass->getAttributes(ComponentSchema::class)[0]->newInstance();
        $componentSchemaAttribute->setRefClass($refClass);
        $componentProps = $componentSchemaAttribute->componentProps();

        $this->assertCount(5, $componentProps);
    }

    public function testSetComponentPropsInComponentSchemaAreCorrectlySet()
    {
        $refClass = new ReflectionClass(ClassWtithComponentSchema::class);
        $componentSchemaAttribute = $refClass->getAttributes(ComponentSchema::class)[0]->newInstance();
        $componentSchemaAttribute->setRefClass($refClass);
        $componentProps = $componentSchemaAttribute->componentProps();

        $this->assertEquals('name', $componentProps[0]->name);
        $this->assertEquals('string', $componentProps[0]->type);
    }

    public function testThrowsExceptionWhenPropertyTypeIsNotBuiltInAndReferencedClassDoesNotAreOneComponent()
    {
        $this->expectException(OnlyComponentClassesCanBeReferencedException::class);
        $this->expectExceptionMessage('Only classes with #[ComponentSchema] attribute can be referenced. Class '. JohnDoeResource::class . ' does not have #[ComponentSchema] attribute.');

        $refClass = new ReflectionClass($this::class);
        $reflectionProp = $refClass->getProperty('propTest');
        $componentPropAttribute = $reflectionProp->getAttributes(ComponentProp::class)[0]->newInstance();
        $componentPropAttribute->setRefPropertie($reflectionProp);
    }

    public function testCreateYamlFromComponentSchema()
    {
        $refClass = new ReflectionClass(ClassWtithComponentSchema::class);
        $componentSchemaAttribute = $refClass->getAttributes(ComponentSchema::class)[0]->newInstance();
        $componentSchemaAttribute->setRefClass($refClass);
        $schemaArray = $componentSchemaAttribute->toArray();
        $yaml = Yaml::dump($schemaArray, 16, 2);
        file_put_contents(__DIR__ . '/SchemaTest1.yaml', $yaml);
        $this->assertEquals(
            preg_replace("/\r\n/", "\n", file_get_contents(__DIR__ . '/SchemaExample1.yaml')),
            file_get_contents(__DIR__ . '/SchemaTest1.yaml')
        );
    }

    public function testCreateYamlFromComponentContainArrays()
    {
        $refClass = new ReflectionClass(AnotherSchema::class);
        $componentSchemaAttribute = $refClass->getAttributes(ComponentSchema::class)[0]->newInstance();
        $componentSchemaAttribute->setRefClass($refClass);
        $schemaArray = $componentSchemaAttribute->toArray();
        $yaml = Yaml::dump($schemaArray, 16, 2);
        file_put_contents(__DIR__ . '/SchemaTest2.yaml', $yaml);
        $this->assertEquals(
            preg_replace("/\r\n/", "\n", file_get_contents(__DIR__ . '/SchemaExample2.yaml')),
            file_get_contents(__DIR__ . '/SchemaTest2.yaml')
        );
    }
}