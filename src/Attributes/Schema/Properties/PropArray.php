<?php 
namespace DocsMaker\Attributes\Schema\Properties;

use Attribute;
use DocsMaker\Attributes\Ref;
use DocsMaker\Attributes\Schema\Properties\PropertyInterface;

#[Attribute]
class PropArray implements PropertyInterface
{
    public function __construct(
        public readonly Ref |PropertyInterface $itemsType,
        public readonly ?string $name = null,
        public readonly ?bool $required = false,
        public readonly ?string $description = '',
        public readonly ?int $minLenght = null,
        public readonly ?int $maxLenght = null,
        public readonly ?int $minItems = null,
        public readonly ?int $maxItems = null,
        public readonly ?bool $deprecated = false,
        public readonly ?string $title = '',
        public readonly ?bool $nullable = false,
        public readonly ?string $example = ''
    ){}
    
    public function type(): string
    {
        return 'array';
    }

    public function toArray(): array
    {
        $array = [
            'type' => $this->Type(),
            'required' => $this->required,
            'description' => $this->description,
            'minLenght' => $this->minLenght,
            'maxLenght' => $this->maxLenght,
            'deprecated' => $this->deprecated,
            'title' => $this->title,
            'nullable' => $this->nullable,
            'example' => $this->example,
            'minItems' => $this->minItems,
            'maxItems' => $this->maxItems,
            'items' => $this->itemsType->toArray()
        ];

        if($this->itemsType instanceof Ref) 
            $array['items'] = ['$ref' => $this->itemsType->name];

        $filteredValues = [];
        foreach ($array as $key => $value) {
            if (!empty($value) && $value !== null) {
                $filteredValues[$key] = $value;
            }
        }

        return $filteredValues;
    }
}