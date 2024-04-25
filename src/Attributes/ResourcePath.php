<?php 
namespace DocsMaker\Attributes;

use Attribute;

#[Attribute]
class ResourcePath
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly string $sumary
    ) {}
} 