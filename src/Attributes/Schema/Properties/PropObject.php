<?php 
namespace DocsMaker\Attributes\Schema\Properties;

use Attribute;
use DocsMaker\Attributes\Ref;
use ReflectionClass;

#[Attribute]
class PropObject implements Property
{
    public ReflectionClass $refClass;
    public function __construct(
        public readonly string $name,
        public readonly bool $required = false,
        public readonly string $description = '',
        public readonly ?int $minProperties = null,
        public readonly ?int $maxProperties = null,
        public readonly ?bool $deprecated = false,
        public readonly ?string $title = '',
        public readonly ?Ref    $ref = null,
        public readonly ?array $properties = []
    )
    {
    }

    public function setRefClass(ReflectionClass $refClass): void
    {
        $this->refClass = $refClass;
    }
    
    public function Type(): string
    {
        return 'object';
    }
}