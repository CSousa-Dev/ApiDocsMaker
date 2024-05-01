<?php 
namespace Test\Integration\ApiIntegrationTest\Components;

use DocsMaker\Attributes\Component\ComponentProp;
use DocsMaker\Attributes\Component\ComponentSchema;

#[ComponentSchema(
    name: 'Test Other Schema',
    description: 'Another Schema Description'
)]
class OtherSchema 
{
    #[ComponentProp]
    public string $name;
}