<?php 
namespace DocsMaker\Attributes;
use Attribute;
use DocsMaker\Exceptions\InvalidMethodException;

#[Attribute]
class Method
{
    public function __construct(
        public string $name
    ) {
        $this->validateMethod($name);
    }

    private function validateMethod(string $method)
    {
        $method = strtoupper($method);
        if(!in_array($method, ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'])) {
            throw new InvalidMethodException();
        }
    }

    public function __toString()
    {
        return $this->name;
    }
}