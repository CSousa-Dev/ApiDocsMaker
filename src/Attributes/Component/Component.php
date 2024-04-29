<?php 
namespace DocsMaker\Attributes\Component;

use Attribute;
use ReflectionClass;
use DocsMaker\Attributes\Component\ComponentProp;

#[Attribute]
abstract class Component
{
    /**
     * @var ComponentProp[]
     */
    private array $propAttributes= [];
    public function findAttributes(ReflectionClass $refClass)
    {
        $classProps      = $refClass->getProperties();

        foreach($classProps as $prop)
        {
            $propAttributes = $prop->getAttributes(ComponentProp::class);
            if($propAttributes)
            {
                $propAttribute = $propAttributes[0]->newInstance();
                $propAttribute->setRefPropertie($prop);
                $this->propAttributes[] = $propAttribute;
            }   
        }
    }

    public function componentProps(): array
    {
        return $this->propAttributes;
    }

    public function componentPropsToArray(): array
    {
        foreach($this->propAttributes as $prop)
        {
            $props[$prop->name] = $prop->toArray();
        }

        return $props;
    }
}