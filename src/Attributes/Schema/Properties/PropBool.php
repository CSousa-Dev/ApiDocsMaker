<?php
namespace DocsMaker\Attributes\Schema\Properties;

use Attribute;
use DocsMaker\Attributes\Schema\Properties\PropertyInterface;
#[Attribute]
class PropBool implements PropertyInterface
{
    public function __construct(
        public readonly ?string $name = '',
        public readonly ?string $description = '',
        public readonly ?bool $deprecated = false,
        public readonly ?string $title = '',
        public readonly bool $required = false,
        public readonly ?bool $nullable = false
    )
    {
    }
    
    public function Type(): string
    {
        return 'boolean';
    }

    public function toArray(): array
    {
        $array = [
            'type' => $this->Type(),
            'required' => $this->required,
            'description' => $this->description,
            'deprecated' => $this->deprecated,
            'title' => $this->title,
            'nullable' => $this->nullable,
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