<?php 
namespace DocsMaker\Attributes;
use Attribute;
use ReflectionMethod;
use DocsMaker\Attributes\Response;
use DocsMaker\Exceptions\InvalidMethodException;
use DocsMaker\Exceptions\MethodWithoutResponsesException;
use DocsMaker\Exceptions\TwoResponsesWithTheSameCodeException;
use ReflectionAttribute;
use Test\Unit\MethodWithResponsesTest;

#[Attribute]
class Method
{
    /**
     * @var Response[]
     */
    private array $responses = [];
    private ReflectionMethod $reflectionMethod;
    public function __construct(
        public string $name
    ) 
    {
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

    public function getName()
    {
        return $this->name;
    }

    public function setRefMethod(ReflectionMethod $method)
    {
        $this->reflectionMethod = $method;
    }

    public function startAttributesAssembly($path)
    {
        $this->extractResponses($path);
    }

    private function extractResponses($path)
    {
        $responses = $this->reflectionMethod->getAttributes(Response::class);
        foreach($responses as $response) {
            $responseInstance = new Response(...$response->getArguments());

            if(isset($this->responses[$responseInstance->getCode()])) {
                throw new TwoResponsesWithTheSameCodeException( $responseInstance->getCode(), $this->name,  $path);
            }

            $this->responses[$responseInstance->getCode()] = $responseInstance;
        }

        if(empty($this->responses)) {
            throw new MethodWithoutResponsesException($path, $this->name);
        }
    }

    public function getResponses()
    {
        return $this->responses;
    }
}