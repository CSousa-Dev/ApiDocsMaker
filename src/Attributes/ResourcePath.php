<?php 
namespace DocsMaker\Attributes;

use Attribute;
use DocsMaker\Attributes\Response;

#[Attribute]
class ResourcePath
{
    private $refMethod;
    private $method;
    private $paramsInPath;
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly string $sumary
    ) {
        $this->extractParamsFromPath();
    }

    public function setRefMethod($method)
    {
        $this->refMethod = $method;
    }

    public function startAttributesAssembly()
    {
        $method = $this->refMethod->getAttributes(Method::class);
        
        if(empty($method)) {
            throw new \Exception('Method attribute is required for path ' . $this->name);
        }

        if(count($method) > 1) {
            throw new \Exception('Only one Method attribute is allowed per resource path attribute declaration');
        }

        $method = $method[0]->newInstance();
        $method->setRefMethod($this->refMethod);
        $method->setRequiredPathParamNames($this->paramsInPath);
        $method->startAttributesAssembly($this->name);
        $this->method = $method;
    }

    private function extractParamsFromPath(){
        $pattern = '/\{(\w+)\}/';
        preg_match_all($pattern, $this->name, $matches);
        $this->paramsInPath = $matches[1];
    }

    public function getMethod(): Method
    {
        return $this->method;
    }
} 