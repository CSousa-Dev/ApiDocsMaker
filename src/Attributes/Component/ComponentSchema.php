<?php
namespace DocsMaker\Attributes\Component;

use Attribute;
use ReflectionClass;
use DocsMaker\Attributes\Component\Component;

#[Attribute]
class ComponentSchema extends Component
{
    private ReflectionClass $refClass;
    public function __construct(
        public  readonly string $name,
        private ?string $description = null,
        private ?string $title = null,
        private ?bool $deprecated = null,
        private ?bool $nullable = null,
    ){}

    public function setRefClass(ReflectionClass $refClass): void
    {
        $this->refClass = $refClass;
        $this->findAttributes($this->refClass);
    }

    public function toArray()
    {
        $array = [
            'description' => $this->description,
            'title' => $this->title,
            'deprecated' => $this->deprecated,
            'nullable' => $this->nullable,
            'properties' => $this->componentPropsToArray()   
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