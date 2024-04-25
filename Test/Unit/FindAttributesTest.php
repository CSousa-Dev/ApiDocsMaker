<?php 
namespace Test\Unit;

use DocsMaker\AttributeFinder;
use PHPUnit\Framework\TestCase;
use DocsMaker\OnFindApiResource;
use DocsMaker\Attributes\ApiResource;

class FindAttributesTest extends TestCase
{
    public function testFindApiResourceAttribute()
    {
        $attributesFinder = new AttributeFinder('Test', "C:\\\Users\\renat\\Documents\\Projetos\\SwaggerDocsMaker\\Test\\FakeApi\\ValidsResources");
        $attributesFinder->findAttribute(new OnFindApiResource,ApiResource::class);
        $apiResources = $attributesFinder->resources();
        $this->assertCount(2, $apiResources);
    }
}