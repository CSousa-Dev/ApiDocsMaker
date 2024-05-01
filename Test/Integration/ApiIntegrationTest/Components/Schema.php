<?php
namespace Test\Integration\ApiIntegrationTest\Components;

use DocsMaker\Attributes\Component\ComponentProp;
use DocsMaker\Attributes\Component\ComponentSchema;
use Test\Integration\ApiIntegrationTest\Components\AnotherSchema;

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