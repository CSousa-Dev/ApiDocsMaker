<?php 
namespace Test\Integration\ApiIntegrationTest;

use DocsMaker\Attributes\Method;
use DocsMaker\Attributes\ApiResource;
use DocsMaker\Attributes\ResourcePath;
use DocsMaker\Attributes\Response;

#[ApiResource('Resource1', 'Another Description for Resource1')]
class Resource1B
{
    #[ResourcePath('/resource1', 'PUT', 'Resource1 get')]
    #[Method('PUT')]
    #[Response('200', 'Resource1 updated')]
    public function put()
    {
        return 'Resource1';
    }
}