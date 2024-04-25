<?php 
namespace Test\FakeApi\ValidsResources;

use DocsMaker\Attributes\ApiResource;

#[ApiResource(name: 'John Doe', description: 'John Doe description')]
class JohnDoeResource
{
    public function __construct()
    {
    }
}