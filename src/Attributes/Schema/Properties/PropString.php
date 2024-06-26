<?php 
namespace DocsMaker\Attributes\Schema\Properties;

use Attribute;
use DocsMaker\Attributes\Schema\Properties\PropertyInterface;

#[Attribute]
class PropString implements PropertyInterface
{
    public function __construct(
        public readonly ?string $name = null,
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
        public readonly ?bool $nullable = false,
        public readonly ?array $enum = []
    )
    {
    }

    public function type(): string
    {
        return 'string';
    }

    public function toArray(): array
    {
        $array = [
            'type' => $this->Type(),
            'required' => $this->required,
            'format' => $this->format,
            'pattern' => $this->pattern,
            'minLength' => $this->minLength,
            'maxLength' => $this->maxLength,
            'default' => $this->default,
            'deprecated' => $this->deprecated,
            'title' => $this->title,
            'description' => $this->description,
            'example' => $this->example,
            'nullable' => $this->nullable,
            'enum' => [
                ...$this->enum
            ] 
        ];  

        $filteredValues = [];
        foreach ($array as $key => $value) {
            if (!empty($value) && $value !== null) {
                $filteredValues[$key] = $value;
            }
        }

        return $filteredValues;
    }
}