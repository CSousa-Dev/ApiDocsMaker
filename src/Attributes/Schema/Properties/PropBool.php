<?php
namespace DocsMaker\Attributes\Schema\Properties;

use Attribute;
#[Attribute]
class PropBool implements Property
{
    public function __construct(
        public readonly string $name,
        public readonly string $description = '',
        public readonly bool $required = false,
    )
    {
    }
    
    public function Type(): string
    {
        return 'boolean';
    }
}