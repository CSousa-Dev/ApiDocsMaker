<?php 
namespace Test\FakeApi\InvalidResources;

use DocsMaker\Attributes\Method;
use DocsMaker\Attributes\Response;
use DocsMaker\Attributes\ApiResource;
use DocsMaker\Attributes\ResourcePath;

#[ApiResource('Contains Two Identical Response Code', 'Contains Two Identical Response Code')]
class ContainsTwoIdenticalResponseCode
{
    #[ResourcePath('/fake', 'fake', 'fake')]
    #[Response(200, 'Success')]
    #[Method('GET')]
    #[Response(200, 'Success')]
    public function get()
    {
        return 'get';
    }
}