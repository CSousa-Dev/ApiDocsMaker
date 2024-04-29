<?php 
namespace DocsMaker\Attributes;

use Attribute;
use DocsMaker\Attributes\Schema\Properties\PropertyInterface;
use PhpParser\Builder\Property;

#[Attribute]
class Parameter
{
    public function __construct(
        public string $name,
        public string $in,
        public PropertyInterface $schema,
        public ?string $description,
        public ?bool $required = true,
        public ?string $deprecated = null,
        public ?string $allowEmptyValue = null,
        public ?string $explode = '',
        public ?string $example = '',
        public ?string $schemaRef = '',
    )
    {
    }

    public function toArray()
    {
        $array =  [
            'name' => $this->name,
            'in' => $this->in,
            'description' => $this->description,
            'required' => $this->required,
            'deprecated' => $this->deprecated,
            'allowEmptyValue' => $this->allowEmptyValue,
            'explode' => $this->explode,
            'example' => $this->example,
            'schema' => $this->schema->toArray()
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