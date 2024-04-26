<?php 
namespace Test\Unit;
use ReflectionClass;
use PHPUnit\Framework\TestCase;
use DocsMaker\OnFindApiResource;
use DocsMaker\Attributes\ApiResource;
use DocsMaker\Exceptions\ExternalDocsWithoutLink;
use DocsMaker\Exceptions\ExternalDocsWithoutName;
use DocsMaker\Exceptions\MultiplesApiResourcePerClassException;

class ApiResourceTest extends TestCase
{
    public function testClassContainApiResourceAttribute()
    {
        $newFakeClass = new FakeClass();
        $reflectionClass = new ReflectionClass($newFakeClass);
        $onFindApiResource = new OnFindApiResource();
        $this->assertTrue($onFindApiResource->execute($reflectionClass) instanceof ApiResource);
    }

    public function testClassContainMultipleApiResourceThrowsException()
    {
        $newFakeClass = new FakeClassWithMultipleApiResource();
        $reflectionClass = new ReflectionClass($newFakeClass);
        $this->expectExceptionMessage('Only one ApiResource attribute is allowed per class');
        $this->expectException(MultiplesApiResourcePerClassException::class);
        $onFindApiResource = new OnFindApiResource();   
        $onFindApiResource->execute($reflectionClass);
    }

    public function testApiResourceWithExternalDocsWithLinkWithoutNameThrowsException()
    {
        $newFakeClass = new FakeClassWithExtenalDocsLinkWithoutExternalDocsName();
        $reflectionClass = new ReflectionClass($newFakeClass);
        $this->expectExceptionMessage('If you want to use linkForExternalDocumentation, you need to pass externalDocsLinkName.');
        $this->expectException(ExternalDocsWithoutName::class);
        $onFindApiResource = new OnFindApiResource();   
        $onFindApiResource->execute($reflectionClass);
    }

    public function testApiResourceWithExternalDocsWithNameWithoutLinkThrowsException()
    {
        $newFakeClass = new FakeClassWithExtenalDocsNameWithoutExternalDocsLink();
        $reflectionClass = new ReflectionClass($newFakeClass);
        $this->expectExceptionMessage('If you want to use externalDocsLinkName, you need to pass linkForExternalDocumentation.');
        $this->expectException(ExternalDocsWithoutLink::class);
        $onFindApiResource = new OnFindApiResource();   
        $onFindApiResource->execute($reflectionClass);
    }

}

#[ApiResource(name: 'FakeClass', description: 'FakeClass description')]
class FakeClass
{
    public function fakeMethod()
    {
        return 'fakeMethod';
    }
}

#[ApiResource(name: 'FakeClass', description: 'FakeClass description')]
#[ApiResource(name: 'FakeClass', description: 'FakeClass description')]
class FakeClassWithMultipleApiResource
{
    public function fakeMethod()
    {
        return 'fakeMethod';
    }
}

#[ApiResource(name: 'FakeClass', description: 'FakeClass description', linkForExternalDoc: 'https://www.google.com')]
class FakeClassWithExtenalDocsLinkWithoutExternalDocsName
{
    public function fakeMethod()
    {
        return 'fakeMethod';
    }
}

#[ApiResource(name: 'FakeClass', description: 'FakeClass description', externalDocsLinkName:'google')]
class FakeClassWithExtenalDocsNameWithoutExternalDocsLink
{
    public function fakeMethod()
    {
        return 'fakeMethod';
    }
}