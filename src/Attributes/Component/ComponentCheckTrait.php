<?php
namespace DocsMaker\Attributes\Component;

use ReflectionClass;
use DocsMaker\Attributes\Component\ComponentResponse;

trait ComponentCheckTrait
{
    public function getComponent($className, string $componentName)
    {
        $reflectionClass = new ReflectionClass($className);
        $attributes = $reflectionClass->getAttributes($componentName);
        if(count($attributes) > 0)
            return $attributes[0]->newInstance();

        return null;
    }
}