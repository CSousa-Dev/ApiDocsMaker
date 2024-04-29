<?php 
namespace Test\FakeApi\Api\Components;

use DocsMaker\Attributes\Component\ArrayItems;
use DocsMaker\Attributes\Component\ComponentProp;
use DocsMaker\Attributes\Component\ComponentSchema;

#[ComponentSchema(
    name: 'Another Schema',
    description: 'Another Schema Description'
)]
class AnotherSchema 
{
    #[ComponentProp(refComponentClass: OtherSchema::class)]
    public object $objetoToOtherSchema;

    #[ComponentProp(
        arrayItems: new ArrayItems(
            type: 'array', 
            arrayItems: new ArrayItems(
                type: 'string'
                )
            )
        )
    ]
    public array $arrayTest;
}