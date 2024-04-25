<?php 
namespace Test\FakeApi\ValidsResources;

use DocsMaker\Attributes\Method;
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
    public function patch()
    {
        return 'PATCH';
    }
}