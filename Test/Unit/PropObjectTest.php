<?php 
namespace Test\Unit;
use ReflectionMethod;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use DocsMaker\Attributes\Schema\Properties\PropObject;
use DocsMaker\Attributes\Schema\Properties\PropString;
use DocsMaker\Exceptions\PropertiesOfProbObjeMustHaveNameException;

class PropObjectTest extends TestCase
{
    #[PropObject(
        properties: [
            new PropString(),
        ]
    )]
    public function testThrowExceptionIfOnePropertieOfObjectDosNotHaveName()
    {
        $this->expectException(PropertiesOfProbObjeMustHaveNameException::class);
        $this->expectExceptionMessage('All properties of an object must have a name');
        $reflectMethod = new ReflectionMethod($this, 'testThrowExceptionIfOnePropertieOfObjectDosNotHaveName');
        $prop = $reflectMethod->getAttributes(PropObject::class)[0]->newInstance();
        $prop->toArray();
    }

    #[PropObject(
        properties: [
            new PropString(name: 'name'),
            new PropString(name: 'name2'),
            new PropObject(name: 'name3', properties: [new PropString('objName')])
        ]
    )]
    public function testCreateObjectWithProperties()
    {
        $reflectMethod = new ReflectionMethod($this, 'testCreateObjectWithProperties');
        $prop = $reflectMethod->getAttributes(PropObject::class)[0]->newInstance();
        $array = $prop->toArray();

        $this->assertContains('name', array_keys($array['properties']));
        $this->assertContains('name2', array_keys($array['properties']));
        $this->assertContains('name3', array_keys($array['properties']));
        $this->assertEquals('object', $array['properties']['name3']['type']);
        $this->assertContains('objName', array_keys($array['properties']['name3']['properties']));
    }

}