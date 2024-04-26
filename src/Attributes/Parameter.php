<?php 
namespace DocsMaker\Attributes;

use Attribute;

#[Attribute]
class Parameter
{
    public function __construct(
        public string $name,
        public string $in,
        public string $description,
        public bool $required = true,
        public string $type = 'string',
        public string $format = 'string',
        public string $default = '',
        public string $example = '',
    )
    {
    }
}