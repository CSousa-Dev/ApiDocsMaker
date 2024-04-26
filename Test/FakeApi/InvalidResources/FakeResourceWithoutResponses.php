<?php 
namespace Test\FakeApi\InvalidResources;

use DocsMaker\Attributes\Method;
use DocsMaker\Attributes\ApiResource;
use DocsMaker\Attributes\ResourcePath;

#[ApiResource('fake resource without responses', 'fake resource without responses')]
class FakeResourceWithoutResponses
{
    #[ResourcePath('/fake', 'fake', 'fake')]
    #[Method('GET')]
    public function get()
    {
        return 'get';
    }
}