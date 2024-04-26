<?php 
namespace DocsMaker\Attributes;

use Attribute;
use DocsMaker\Attributes\Response;

#[Attribute]
class ResourcePath
{
    public $refMethod;
    public $method;
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly string $sumary
    ) {}

    public function setRefMethod($method)
    {
        $this->refMethod = $method;
    }

    public function startAttributesAssembly()
    {
        $method = $this->refMethod->getAttributes(Method::class);
        if(empty($method)) {
            throw new \Exception('Method attribute is required');
        }

        if(count($method) > 1) {
            throw new \Exception('Only one Method attribute is allowed per resource path attribute declaration');
        }

        $method = $method[0]->newInstance();
        $method->setRefMethod($this->refMethod);
        $method->startAttributesAssembly($this->name);
        $this->method = $method;
    }

    public function getMethod()
    {
        return $this->method;
    }
} 