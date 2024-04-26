<?php
namespace Test\Unit;
use ReflectionClass;
use PHPUnit\Framework\TestCase;
use DocsMaker\OnFindApiResource;
use DocsMaker\Attributes\Response;
use Test\FakeApi\ValidsResources\JohnDoeResource;
use DocsMaker\Exceptions\MethodWithoutResponsesException;
use DocsMaker\Exceptions\TwoResponsesWithTheSameCodeException;
use Test\FakeApi\InvalidResources\FakeResourceWithoutResponses;
use Test\FakeApi\InvalidResources\ContainsTwoIdenticalResponseCode;

class MethodWithResponsesTest extends TestCase
{
    public function testThrowsExceptionWhenPathDoesNotContainResponses()
    {
        $this->expectExceptionMessage("Path /fake with method GET does not have any responses. At least one response is required.");
        $this->expectException(MethodWithoutResponsesException::class);
        $newFakeClass = new FakeResourceWithoutResponses();
        $reflectionClass = new ReflectionClass($newFakeClass);
        $onFindApiResource = new OnFindApiResource();
        $resource = $onFindApiResource->execute($reflectionClass);
        $resource->startAttributesAssembly();
    }

    public function testThrowsExceptionWhenHasTwoResponsesWithTheSameCode()
    {
        $this->expectExceptionMessage("Two responses with the same code: 200 for the same method GET in path /fake. Each response code must be unique.");
        $this->expectException(TwoResponsesWithTheSameCodeException::class);
        $newFakeClass = new ContainsTwoIdenticalResponseCode();
        $reflectionClass = new ReflectionClass($newFakeClass);
        $onFindApiResource = new OnFindApiResource();
        $resource = $onFindApiResource->execute($reflectionClass);
        $resource->startAttributesAssembly();
    }

    public function testMethodContainsResponses()
    {
        $newFakeClass = new JohnDoeResource();
        $reflectionClass = new ReflectionClass($newFakeClass);
        $onFindApiResource = new OnFindApiResource();
        $resource = $onFindApiResource->execute($reflectionClass);
        $resource->startAttributesAssembly();
        $paths = $resource->getPaths();
        $methods = $paths[0]->getMethod();
        $responses = $methods->getResponses();

        $this->assertCount(4, $responses);
        $this->assertContainsOnlyInstancesOf(Response::class, $responses);
    }
}