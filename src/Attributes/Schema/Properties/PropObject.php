<?php 
namespace DocsMaker\Attributes\Schema\Properties;

use Attribute;
use ReflectionClass;
use DocsMaker\Attributes\Ref;
use DocsMaker\Attributes\Component\ComponentCheckTrait;
use DocsMaker\Attributes\Schema\Properties\PropertyInterface;
use DocsMaker\Exceptions\PropertiesOfProbObjeMustHaveNameException;
use DocsMaker\Exceptions\PropertiesOfProbObjeMustBeInstanceOfPropertyInterfaceException;

#[Attribute]
class PropObject implements PropertyInterface
{
    use ComponentCheckTrait;
    public ReflectionClass $refClass;
    public function __construct(
        public readonly array $properties = [],
        public readonly string $ref = '',
        public readonly ?string     $name = '',
        public readonly ?bool       $required = false,
        public readonly ?string     $description = '',
        public readonly ?int        $minProperties = null,
        public readonly ?int        $maxProperties = null,
        public readonly ?bool       $deprecated = false,
        public readonly ?string     $title = ''
    )
    {
        $this->allObjPropertiesMustBeContainName();
        if(!empty($ref))
            $this->setReferencedSchema();
    }

    public function setRefClass(ReflectionClass $refClass): void
    {
        $this->refClass = $refClass;
    }

    private function setReferencedSchema()
    {
        if(!empty($this->properties))
            trigger_error('properties will be ignored when ref is set' , E_USER_WARNING);
    }
    
    public function type(): string
    {
        return 'object';
    }

    
    private function allObjPropertiesMustBeContainName()
    {
        foreach($this->properties as $property)
        {
            if(!($property instanceof PropertyInterface))
                throw new PropertiesOfProbObjeMustBeInstanceOfPropertyInterfaceException();
            
            if(empty($property->name))
                throw new PropertiesOfProbObjeMustHaveNameException();
        }
    }

    public function toArray(): array
    {
        $array = [
            "type" => $this->type(),
            "required" => $this->required,
            "description" => $this->description,
            "minProperties" => $this->minProperties,
            "maxProperties" => $this->maxProperties,
            "deprecated" => $this->deprecated,
            "title" => $this->title
        ];

        if($this->properties instanceof Ref){
            $ref = $this->properties;
            $array['properties'] = ['$ref' => $ref->name];
        }
        
        if(is_array($this->properties))
            $array['properties'] = $this->makePropertiesArray();
    
        $filteredValues = [];
        foreach ($array as $key => $value) {
            if (!empty($value) && $value !== null) {
                $filteredValues[$key] = $value;
            }
        }

        return $filteredValues;
    }

    private function makePropertiesArray(): array
    {
        $properties = [];
        foreach($this->properties as $property)
        {
            $properties[$property->name] = $property->toArray();
        }
        return $properties;
    }
}