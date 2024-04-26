<?php 
namespace Test\FakeApi\ValidsResources;

use DocsMaker\Attributes\Method;
use DocsMaker\Attributes\Response;
use DocsMaker\Attributes\ApiResource;
use DocsMaker\Attributes\ResourcePath;

#[ApiResource('Some Resource', 'Lorem ipsum dolor sit amet')]
class SomeCorrectResource
{
    #[ResourcePath(
        name:'/resource', 
        description:'Lorem ipsum dolor sit amet', 
        sumary: 'Lorem ipsum dolor sit amet'
    )]
    #[Method('GET')]	
    #[Response(200, 'Success')]
    public function get()
    {
        return 'GET';
    }

    #[ResourcePath(
        name:'/resource', 
        description:'Lorem ipsum dolor sit amet', 
        sumary: 'Lorem ipsum dolor sit amet'
    )]
    #[Method('POST')]
    #[Response(200, 'Success')]
    public function post()
    {
        return 'POST';
    }

    #[ResourcePath(
        name:'/resource', 
        description:'Lorem ipsum dolor sit amet',
        sumary: 'Lorem ipsum dolor sit amet'
    )]
    #[Method('PUT')]
    #[Response(200, 'Success')]
    public function put()
    {
        return 'PUT';
    }

    #[ResourcePath(
        name:'/resource', 
        description:'Lorem ipsum dolor sit amet', 
        sumary: 'Lorem ipsum dolor sit amet'
    )]
    #[Method('DELETE')]
    #[Response(200, 'Success')]
    public function delete()
    {
        return 'DELETE';
    }

    #[ResourcePath(
        name:        '/resource', 
        description: 'Lorem ipsum dolor sit amet', 
        sumary:      'Lorem ipsum dolor sit amet'
    )]
    #[Method(name:'PATCH')]
    #[Response(200, 'Success')]
    public function patch()
    {
        return 'PATCH';
    }
}