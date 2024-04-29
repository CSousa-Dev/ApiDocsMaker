<?php 
namespace DocsMaker\Attributes\Component;

use Attribute;
#[Attribute]
class Type
{
    /**
     * @param 'array' | 'object' | 'string' | 'int' | 'boolean' | 'float' $type
     */
    public function __construct(public readonly string $name)
    {
    }
}