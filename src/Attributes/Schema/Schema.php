<?php 
namespace DocsMaker\Attributes\Schema;

use Attribute;
use DocsMaker\Attributes\Schema\Properties\PropertyInterface;
use DocsMaker\Attributes\Schema\Properties\PropObject;
use ReflectionClass;

#[Attribute]
class Schema
{
    private ReflectionClass $refClass;
    public function __construct(
        private PropertyInterface $property,
    )
    {}

    public function setRefClass(ReflectionClass $refClass): void
    {
        $this->refClass = $refClass;
    }

    public function toArray()
    {

        $properties['type'] = $this->property->type();   
        $properties['type'] = $this->property->toArray();
        $properties['title'] = $this->title;
        $properties['description'] = $this->description;
        $properties['deprecated'] = $this->deprecated;
        $properties['nullable'] = $this->nullable;
       
        $filteredValues = [];
        foreach ($properties as $key => $value) {
            if (!empty($value) && $value !== null) {
                $filteredValues[$key] = $value;
            }
        }
       
        return $filteredValues;
    }
}