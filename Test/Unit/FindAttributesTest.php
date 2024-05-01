<?php 
namespace Test\Unit;

use DocsMaker\AttributeFinder;
use PHPUnit\Framework\TestCase;
use DocsMaker\Attributes\Method;
use DocsMaker\OnFindApiResource;
use DocsMaker\Attributes\ApiResource;
use DocsMaker\Attributes\ResourcePath;
use DocsMaker\Exceptions\TwoIdenticalPathsException;
use Test\FakeApi\InvalidResources\ContainsTwoIdenticalPaths;

class FindAttributesTest extends TestCase
{
    protected $apiResources;
    protected function setUp(): void
    {
        $attributesFinder = new AttributeFinder('Test', "C:\\\Users\\renat\\Documents\\Projetos\\SwaggerDocsMaker\\Test\\FakeApi\\ValidsResources");
        $attributesFinder->findAttribute(new OnFindApiResource, ApiResource::class);
        $this->apiResources =  $attributesFinder->match();
    }

    public function testFindApiResourceAttribute()
    {
        $this->assertCount(2, $this->apiResources);
    }

    public function testIfAttributesPathInClassUsingApiResource()
    {
        $johnDoeResource = $this->apiResources[0];
        $johnDoeResource->startAttributesAssembly();
        $paths = $johnDoeResource->getPaths();
        $this->assertCount(3, $paths);
        $this->assertContainsOnlyInstancesOf(ResourcePath::class, $paths);
    }

    public function testIfAttributesMethodsInAttributesPath()
    {
        $johnDoeResource = $this->apiResources[0];
        $johnDoeResource->startAttributesAssembly();
        $paths = $johnDoeResource->getPaths();  
        $methods = [];
        foreach($paths as $path) {
            $methods[] = $path->getMethod();
        }

        $this->assertCount(3, $methods);
        $this->assertContainsOnlyInstancesOf(Method::class, $methods);
    }

    public function testThrowsExceptionWhenClassContainsTwoIdenticalPaths()
    {
        $this->expectExceptionMessage('Two identical paths: /test and method GET found in the same resource. Please make sure that each path is unique.');
        $this->expectException(TwoIdenticalPathsException::class);
        $onFindApiResource = new OnFindApiResource;
        $apiResources = $onFindApiResource->execute(new \ReflectionClass(ContainsTwoIdenticalPaths::class));
        $apiResources->startAttributesAssembly();
    }
}