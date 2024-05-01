<?php 
namespace DocsMaker;
use ReflectionClass;
use DocsMaker\OnFindInterface;
use DocsMaker\Attributes\Component\Component;
use DocsMaker\Attributes\Component\ComponentSchema;

class OnFindComponentSchema implements OnFindInterface
{
    private ReflectionClass $reflectionClass;

    public function execute(ReflectionClass $reflectionClass)
    {
        $this->reflectionClass = $reflectionClass;
        return $this->extractComponentAttribute();
    }

    private function extractComponentAttribute()
    {
        $component = $this->reflectionClass->getAttributes(ComponentSchema::class)[0]->newInstance();
        $component->setRefClass($this->reflectionClass);
        return $component;
    }
}