<?php
namespace DocsMaker\Attributes\Component;

use ReflectionClass;
use ReflectionProperty;
use ReflectionUnionType;
use DocsMaker\Exceptions\OnlyComponentClassesCanBeReferencedException;
use DocsMaker\Exceptions\ComponentObjectPropWithoutRefComponentClassException;
use DocsMaker\Exceptions\ArrayItemsIsRequiredForComponentWhenPropertyIsArrayException;
use DocsMaker\Exceptions\OnlyObjectTypedPropComponentsCanReceiveComponentReferenceException;
use DocsMaker\Exceptions\OnlyObjectOrArrayTypedPropComponentsCanReceiveComponentReferenceException;
use InvalidArgumentException;

class ArrayItems 
{
    private string $refComponent;
    private ReflectionProperty $refPropertie;
    public function __construct(
        public ?string          $type               = null,
        public ?string          $name               = null,
        public readonly ?bool   $nullable           = null,
        public readonly ?string $format             = null,
        public readonly ?string $example            = null,
        public readonly ?string $enum               = null,
        public readonly ?string $description        = null,
        public readonly ?bool   $required           = null,
        public readonly ?string $deprecated         = null,
        public readonly ?string $allowEmptyValue    = null,
        public readonly ?string $explode            = null,
        public          ?string $refComponentClass  = null,
        public readonly ?ArrayItems $arrayItems     = null,
    ){
       $this->validateType(); 
    }

    public function getReferencedClass($className)
    {
        if($this->type !== 'object')
            throw new OnlyObjectTypedPropComponentsCanReceiveComponentReferenceException();
        
        $reflectionClass = new ReflectionClass($className);
        $attributes = $reflectionClass->getAttributes(ComponentSchema::class);

        if(!$attributes)
            throw new OnlyComponentClassesCanBeReferencedException($className);

        $component = $attributes[0]->newInstance();
        $component->findAttributes($reflectionClass);
        $this->refComponent = $component->name;
    }

    private function validateType()
    {
        $unchecked = $this->type;
        $suportedTypes = ['integer', 'boolean', 'number', 'string', 'object', 'array'];

        if(!in_array($unchecked, $suportedTypes))
            throw new InvalidArgumentException('Invalid type: ' . $unchecked . ' for property: ' . $this->name);

        if(($this->type === 'array') && $this->arrayItems === null)
            throw new ArrayItemsIsRequiredForComponentWhenPropertyIsArrayException();

            
        if($this->type === 'object') {
            if($this->refComponentClass === null)
                throw new ComponentObjectPropWithoutRefComponentClassException();
            $this->getReferencedClass($this->refComponentClass);
        }            
    }

    public function toArray()
    {
        $array = [
            'type'              => $this->type,
            'name'              => $this->name,
            'nullable'          => $this->nullable,
            'format'            => $this->format,
            'example'           => $this->example,
            'enum'              => $this->enum,
            'description'       => $this->description,
            'required'          => $this->required,
            'deprecated'        => $this->deprecated,
            'allowEmptyValue'   => $this->allowEmptyValue,
            'explode'           => $this->explode,
            'refComponent'      => $this->refComponent,
            'arrayItems'        => $this->arrayItems?->toArray()
        ];
        
        return $array;
    }
}