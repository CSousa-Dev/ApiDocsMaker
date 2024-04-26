<?php 
namespace Test\FakeApi\ValidsResources;

use DocsMaker\Attributes\Method;
use DocsMaker\Attributes\Response;
use DocsMaker\Attributes\ApiResource;
use DocsMaker\Attributes\ResourcePath;

#[ApiResource(name: 'John Doe', description: 'John Doe description')]
class JohnDoeResource
{
    #[ResourcePath(
        name:'/resource', 
        description:'Lorem ipsum dolor sit amet', 
        sumary: 'Lorem ipsum dolor sit amet'
    )]
    #[Method('GET')]
    #[Response(200, 'Success')]
    #[Response(204, 'Created')]
    #[Response(404, 'Not found')]
    #[Response(500, 'Server error')]
    public function fakeMethod()
    {
        return 'fakeMethod';
    }

    #[ResourcePath(
        name:'/resource', 
        description:'Lorem ipsum dolor sit amet', 
        sumary: 'Lorem ipsum dolor sit amet'
    )]
    #[Method('POST')]
    #[Response(200, 'Success')]
    public function fakeMethod2()
    {
        return 'fakeMethod2';
    }

    #[ResourcePath(
        name:'/fakeResource', 
        description:'Lorem ipsum dolor sit amet',
        sumary: 'Lorem ipsum dolor sit amet'
    )]
    #[Method('PUT')]
    #[Response(200, 'Success')]
    public function fakeMethod3()
    {
        return 'fakeMethod3';
    }
}