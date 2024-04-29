<?php
namespace DocsMaker\Attributes\Component;

use Attribute;
use ReflectionClass;
use ReflectionProperty;
use ReflectionUnionType;
use InvalidArgumentException;
use DocsMaker\Exceptions\OnlyComponentClassesCanBeReferencedException;
use DocsMaker\Exceptions\ComponentObjectPropWithoutRefComponentClassException;
use DocsMaker\Exceptions\ArrayItemsIsRequiredForComponentWhenPropertyIsArrayException;
use DocsMaker\Exceptions\OnlyObjectTypedPropComponentsCanReceiveComponentReferenceException;

#[Attribute]
class ComponentProp 
{
    private ReflectionProperty $refPropertie;
    public function __construct(
        public ?string          $name               = null,
        public ?string          $type               = null,
        public readonly ?bool   $nullable           = null,
        public readonly ?string $format             = null,
        public readonly ?string $example            = null,
        public readonly ?string $enum               = null,
        public readonly ?string $description        = null,
        public readonly ?bool   $required           = null,
        public readonly ?string $deprecated         = null,
        public readonly ?string $allowEmptyValue    = null,
        public readonly ?string $explode            = null,
        public ?string          $refComponentClass  = null,
        public readonly ?ArrayItems $arrayItems     = null,
        public ?string          $refComponenteClassName = null
    ){}

    public function setRefPropertie(ReflectionProperty $reflectionProperty)
    {
        $this->refPropertie =  $reflectionProperty;
        $this->setPropName();
        $this->setPropTypeFromPropertie();
        $this->validateType();
    }

    private function setPropName()
    {
        if($this->name === null)
            $this->name = $this->refPropertie->getName();
    }

    private function setPropTypeFromPropertie()
    {
        if($this->type !== null){
            return;
        }

        if($this->type === null)
            $this->getTypeFromPropertie();
    }

    private function getTypeFromPropertie()
    {
        $type = $this->refPropertie->getType();

        $isMultipleTypes = $type instanceof ReflectionUnionType;

        if(!$isMultipleTypes && $type->isBuiltin()){
            $this->type = $type->getName();
            return;
        }

        if(!$isMultipleTypes && !$type->isBuiltin()){
            $this->type = 'object'; 
            $this->getReferencedClass($type->getName());
            return;
        }
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
        $this->refComponentClass = $className;
        $this->refComponenteClassName = $component->name;
    }

    private function validateType()
    {
        $this->type = match($this->type){
            'int' => 'integer',
            'bool' => 'boolean',
            'float' => 'number',
            default => $this->type
        };

        $unchecked = $this->type;
        $suportedTypes = ['integer', 'boolean', 'number', 'string', 'object', 'array'];

        if(!in_array($unchecked, $suportedTypes))
            throw new InvalidArgumentException('Invalid type: ' . $unchecked . ' for property: ' . $this->name);

        if(($this->type === 'array') && $this->arrayItems === null)
            throw new ArrayItemsIsRequiredForComponentWhenPropertyIsArrayException();

            
        if($this->type === 'object') {
            if($this->refComponentClass === null)
                throw new ComponentObjectPropWithoutRefComponentClassException();
            
            if($this->refComponenteClassName !== null) return;
            $this->getReferencedClass($this->refComponentClass);
        }            
    }

    public function toArray()
    {
        $array = [
            'type'              => $this->type,
            'nullable'          => $this->nullable,
            'format'            => $this->format,
            'example'           => $this->example,
            'enum'              => $this->enum,
            'description'       => $this->description,
            'required'          => $this->required,
            'deprecated'        => $this->deprecated,
            'allowEmptyValue'   => $this->allowEmptyValue,
            'explode'           => $this->explode
            // 'arrayItems'        => $this->arrayItems?->toArray()
        ];

        if($this->refComponenteClassName !== null){
            $array = ['$ref' => '#/components/schemas/' . $this->refComponenteClassName];
        }
        

        $filteredValues = [];
        foreach ($array as $key => $value) {
            if (!empty($value) && $value !== null) {
                $filteredValues[$key] = $value;
            }
        }
       
        return $filteredValues;
    }
}