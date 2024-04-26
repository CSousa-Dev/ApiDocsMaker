<?php 
namespace DocsMaker\Attributes\Schema\Types;

use Attribute;
use DocsMaker\Attributes\Schema\Properties\Property;

#[Attribute]
class PropString implements Property
{
    public function __construct(
        public readonly string $name = null,
        public readonly ?bool $required = false,
        public readonly ?string $format = '',
        public readonly ?string $pattern = '',
        public readonly ?int $minLength = null,
        public readonly ?int $maxLength = null,
        public readonly ?string $default = '',
        public readonly ?bool $deprecated = false,
        public readonly ?string $title = '',
        public readonly ?string $description = '',
        public readonly ?string $example = '',
    )
    {
    }

    public function Type(): string
    {
        return 'string';
    }
}