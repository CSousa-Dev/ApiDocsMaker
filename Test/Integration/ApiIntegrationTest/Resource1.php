<?php 
namespace Test\Integration\ApiIntegrationTest;

use DocsMaker\Attributes\Method;
use DocsMaker\Attributes\Params;
use DocsMaker\Attributes\Response;
use DocsMaker\Attributes\Parameter;
use DocsMaker\Attributes\ApiResource;
use DocsMaker\Attributes\ResourcePath;
use DocsMaker\Attributes\Schema\Properties\PropString;

#[ApiResource('Resource1', 'Resource1 description')]
class Resource1
{
    #[ResourcePath('/resource1/{id}/{name}', 'GET', 'Resource1 get')]
    #[Params(
        new Parameter(
            name: 'id', 
            in:'path', 
            description:'Id of the resource', 
            schema: new PropString()
        )
    )]
    #[Method('GET')]
    #[Response('200', 'Resource1 updated')]
    public function get()
    {
        return 'Resource1';
    }

    #[ResourcePath('/resource1', 'GET', 'Resource1 get')]
    #[Method('GET')]
    #[Response('200', 'Resource1 updated')]
    public function getAll()
    {
        return 'Resource1';
    }
}