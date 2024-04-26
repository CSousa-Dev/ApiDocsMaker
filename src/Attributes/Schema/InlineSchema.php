<?php 

namespace DocsMaker\Attributes\Schema;

use Attribute;
use DocsMaker\Attributes\Schema\Properties\Property;

#[Attribute]
class InlineSchema
{
    public function __construct(
        private readonly string $title,
        private readonly string $descritpion = '',
        private Property $property
    )
    {
    }
}