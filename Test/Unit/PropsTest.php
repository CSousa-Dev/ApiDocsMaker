<?php

use PHPUnit\Framework\TestCase;
use DocsMaker\Attributes\Schema\Properties\PropBool;
use DocsMaker\Attributes\Schema\Properties\PropArray;
use DocsMaker\Attributes\Schema\Properties\PropString;
use DocsMaker\Attributes\Schema\Properties\PropInteger;
use DocsMaker\Attributes\Schema\Properties\PropNumber;

class PropsTest extends TestCase
{
    #[PropString(
        name: 'name',
        required: true,
        description: 'description',
        minLength: 1,
        maxLength: 10,
        pattern: '^[a-zA-Z0-9_]*$',
        title: 'title',
        format: 'format',
        example: 'example',
        enum: ['enum1', 'enum2'],
        default: 'default',
        deprecated: true,
        nullable: true       
    )]
    public function testStringProp()
    {   
        $reflectMethod = new ReflectionMethod($this, 'testStringProp');
        $prop = $reflectMethod->getAttributes(PropString::class)[0]->newInstance();

        $array = $prop->toArray();
        $this->assertEquals('string', $array['type']);
        $this->assertEquals(true, $array['required']);
        $this->assertEquals('description', $array['description']);
        $this->assertEquals(1, $array['minLength']);
        $this->assertEquals(10, $array['maxLength']);
        $this->assertEquals('^[a-zA-Z0-9_]*$', $array['pattern']);
        $this->assertEquals(true, $array['deprecated']);
        $this->assertEquals('title', $array['title']);
        $this->assertEquals('format', $array['format']);
        $this->assertEquals('example', $array['example']);
        $this->assertEquals(['enum1', 'enum2'], $array['enum']);
        $this->assertEquals('default', $array['default']);
        $this->assertEquals(true, $array['nullable']);
    }

    #[PropInteger(
        name: 'name',
        required: true,
        description: 'description',
        format: 'format',
        minimum: 1,
        maximum: 10,
        default: 5,
        title: 'title',
        example: 10,
        nullable: true
    )]
    public function testIntegerProp()
    {
        $reflectMethod = new ReflectionMethod($this, 'testIntegerProp');
        $prop = $reflectMethod->getAttributes(PropInteger::class)[0]->newInstance();
        $array = $prop->toArray();
        $this->assertEquals('integer', $array['type']);
        $this->assertEquals(true, $array['required']);
        $this->assertEquals('description', $array['description']);
        $this->assertEquals('format', $array['format']);
        $this->assertEquals(1, $array['minimum']);
        $this->assertEquals(10, $array['maximum']);
        $this->assertEquals(5, $array['default']);
        $this->assertEquals('title', $array['title']);
        $this->assertEquals(10, $array['example']);
        $this->assertEquals(true, $array['nullable']); 
    }

    #[PropNumber(
        name: 'name',
        required: true,
        description: 'description',
        format: 'format',
        minimum: 1,
        maximum: 10,
        default: 5,
        title: 'title',
        example: 'example',
        nullable: true
    )]
    public function testNumberProp()
    {
        $reflectMethod = new ReflectionMethod($this, 'testNumberProp');
        $prop = $reflectMethod->getAttributes(PropNumber::class)[0]->newInstance();
        $array = $prop->toArray();
        $this->assertEquals('number', $array['type']);
        $this->assertEquals(true, $array['required']);
        $this->assertEquals('description', $array['description']);
        $this->assertEquals('format', $array['format']);
        $this->assertEquals(1, $array['minimum']);
        $this->assertEquals(10, $array['maximum']);
        $this->assertEquals(5, $array['default']);
        $this->assertEquals('title', $array['title']);
        $this->assertEquals('example', $array['example']);
        $this->assertEquals(true, $array['nullable']); 
    }

    #[PropBool(
        name: 'name',
        description: 'description',
        required: true,
        deprecated: true,
        title: 'title'
    )]
    public function testBooleanProp()
    {
        $reflectMethod = new ReflectionMethod($this, 'testBooleanProp');
        $prop = $reflectMethod->getAttributes(PropBool::class)[0]->newInstance();
        $array = $prop->toArray();
        $this->assertEquals('boolean', $array['type']);
        $this->assertEquals(true, $array['required']);
        $this->assertEquals('description', $array['description']);
        $this->assertEquals(true, $array['deprecated']);
        $this->assertEquals('title', $array['title']);
    }

    #[PropArray(
        name: 'name',
        required: true,
        description: 'description',
        minLenght: 1,
        maxLenght: 10,
        deprecated: true,
        title: 'title',
        itemsType: new PropString(),
        example: 'example',
        nullable: true,
        minItems: 30,
        maxItems: 30
    )]
    public function testArrayPropWithPrimitiveType()
    {
        $reflectMethod = new ReflectionMethod($this, 'testArrayPropWithPrimitiveType');
        $prop = $reflectMethod->getAttributes(PropArray::class)[0]->newInstance();
        $array = $prop->toArray();
        $this->assertEquals('array', $array['type']);
        $this->assertEquals(true, $array['required']);
        $this->assertEquals('description', $array['description']);
        $this->assertEquals(1, $array['minLenght']);
        $this->assertEquals(10, $array['maxLenght']);
        $this->assertEquals(true, $array['deprecated']);
        $this->assertEquals('title', $array['title']);
        $this->assertEquals('example', $array['example']);
        $this->assertEquals(true, $array['nullable']);
        $this->assertEquals(30, $array['minItems']);
        $this->assertEquals(30, $array['maxItems']);
    }

    #[PropString()]
    #[PropNumber()]
    #[PropInteger()]
    #[PropBool()]
    #[PropArray(itemsType: new PropString())]
    public function testArrayReturnMustBeConstainsOnlyAddedValues()
    {
        $reflectMethod = new ReflectionMethod($this, 'testArrayReturnMustBeConstainsOnlyAddedValues');
        $propString = $reflectMethod->getAttributes(PropString::class)[0]->newInstance();
        $propNumber = $reflectMethod->getAttributes(PropNumber::class)[0]->newInstance();
        $propInteger = $reflectMethod->getAttributes(PropInteger::class)[0]->newInstance();
        $propBool = $reflectMethod->getAttributes(PropBool::class)[0]->newInstance();
        $propArray = $reflectMethod->getAttributes(PropArray::class)[0]->newInstance();

        $arrayString = $propString->toArray();
        $arrayNumber = $propNumber->toArray();
        $arrayInteger = $propInteger->toArray();
        $arrayBool = $propBool->toArray();
        $arrayArray = $propArray->toArray();

        $this->assertEquals('string', $arrayString['type']);
        $this->assertCount(1, $arrayString);
        $this->assertEquals('number', $arrayNumber['type']);
        $this->assertCount(1, $arrayNumber);
        $this->assertEquals('integer', $arrayInteger['type']);
        $this->assertCount(1, $arrayInteger);
        $this->assertEquals('boolean', $arrayBool['type']);
        $this->assertCount(1, $arrayBool);
        $this->assertEquals('array', $arrayArray['type']);
        $this->assertContains('items', array_keys($arrayArray));
        $this->assertCount(2, $arrayArray);
    }


}