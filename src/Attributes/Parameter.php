<?php 
namespace DocsMaker\Attributes;

use Attribute;
use DocsMaker\Attributes\Schema\Properties\PropertyInterface;
use PhpParser\Builder\Property;

#[Attribute]
class Parameter
{
    public function __construct(
        public string               $name,
        public string               $in,
        public PropertyInterface    $schema,
        public readonly ?string     $description,
        public readonly ?bool       $required = true,
        public readonly ?string     $deprecated = null,
        public readonly ?string     $allowEmptyValue = null,
        public readonly ?string     $explode = '',
        public readonly ?string     $example = '',
        public readonly ?string     $schemaRef = '',
        public readonly ?string     $forPath = ''
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

    public function isInPath()
    {
        return strtolower($this->in) === 'path';
    }
}