<?php
namespace DocsMaker;

use ReflectionClass;
use DocsMaker\OnFindInterface;
use DocsMaker\Attributes\ApiResource;
use DocsMaker\Exceptions\MultiplesApiResourcePerClassException;

class OnFindApiResource implements OnFindInterface
{
    private ReflectionClass $reflectionClass;


    public function execute(ReflectionClass $reflectionClass)
    {
        $this->reflectionClass = $reflectionClass;
        return $this->extractApiResourceAttribute();
    }

    private function extractApiResourceAttribute()
    {

        if(count($this->reflectionClass->getAttributes(ApiResource::class)) > 1) 
            throw new MultiplesApiResourcePerClassException();
        
        return $this->reflectionClass->getAttributes(ApiResource::class)[0]->newInstance();
    }
}