<?php 
namespace DocsMaker\Attributes\Schema\Properties;

use Attribute;
use DocsMaker\Attributes\Ref;

#[Attribute]
class PropArray implements Property
{
    public function __construct(
        public readonly string $name,
        public readonly bool $required = false,
        public readonly string $description = '',
        public readonly ?int $minLenght = null,
        public readonly ?int $maxLenght = null,
        public readonly ?bool $deprecated = false,
        public readonly ?string $title = '',
        public readonly ?Ref $ref,
        public readonly ?array $properties = []
    )
    {
    }
    
    public function Type(): string
    {
        return 'object';
    }
}