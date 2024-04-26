<?php
namespace Test\FakeApi\InvalidResources;

use DocsMaker\Attributes\Method;
use DocsMaker\Attributes\Response;
use DocsMaker\Attributes\ApiResource;
use DocsMaker\Attributes\ResourcePath;

#[ApiResource('test identical paths', 'test identical paths')]
class ContainsTwoIdenticalPaths
{
    #[ResourcePath('/test', 'test', 'test')]
    #[Method('GET')]
    #[Response(200, 'Success')]
    public function get(): void
    {
    }

    #[ResourcePath('/test', 'test', 'test')]
    #[Method('GET')]
    #[Response(200, 'Success')]
    public function post(): void
    {
    }
}