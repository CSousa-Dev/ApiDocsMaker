<?php 
namespace DocsMaker\Attributes\Schema\Properties;

use Attribute;
use DocsMaker\Attributes\Schema\Properties\PropertyInterface;
#[Attribute]
class PropNumber implements PropertyInterface
{
    public function __construct(
        public readonly ?string $name = '',
        public readonly ?bool $required = false,
        public readonly ?string $description = '',
        public readonly ?string $format = '',
        public readonly ?int $minimum = null,
        public readonly ?int $maximum = null,
        public readonly ?int $default = null,
        public readonly ?bool $nullable = false,
        public readonly ?string $example = '',
        public readonly ?string $title = '',
        public readonly ?array $enum = []
    ){}

    public function type(): string
    {
        return 'number';
    }

    public function toArray(): array
    {
        $array = [
            'type' => $this->type(),
            'required' => $this->required,
            'description' => $this->description,
            'format' => $this->format,
            'minimum' => $this->minimum,
            'maximum' => $this->maximum,
            'default' => $this->default,
            'nullable' => $this->nullable,
            'title' => $this->title,
            'example' => $this->example,
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