<?php
namespace Test\FakeApi\Api\Components;

use Test\FakeApi\Api\Components\AnotherSchema;
use DocsMaker\Attributes\Component\ComponentProp;
use DocsMaker\Attributes\Component\ComponentSchema;

#[ComponentSchema(
    name: 'Schema Test',
    description: 'Schema Test Description'
)]
class Schema
{
    #[ComponentProp]
    public string $name;

    #[ComponentProp]
    private AnotherSchema $anotherSchema;

    #[ComponentProp]
    public string $description;    

    #[ComponentProp]
    public float $floatProp;

    #[ComponentProp]
    public int $intProp;

    

}