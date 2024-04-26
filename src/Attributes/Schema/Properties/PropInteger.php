<?php 
namespace DocsMaker\Attributes\Schema\Properties;

use Attribute;
#[Attribute]
class PropInteger implements Property
{
    public function __construct(
        public readonly string $name,
        public readonly bool $required = false,
        public readonly ?int $minimum = null,
        public readonly ?int $maximum = null,
        public readonly ?int $default = null,
    ){}

    public function Type(): string
    {
        return 'integer';
    }
    
}