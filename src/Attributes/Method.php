<?php 
namespace DocsMaker\Attributes;
use Attribute;
use ReflectionMethod;
use ReflectionAttribute;
use DocsMaker\Attributes\Response;
use Test\Unit\MethodWithResponsesTest;
use DocsMaker\Exceptions\InvalidMethodException;
use DocsMaker\Exceptions\MethodWithoutResponsesException;
use DocsMaker\Exceptions\MethodWithoutRequestBodyException;
use DocsMaker\Exceptions\TwoResponsesWithTheSameCodeException;

#[Attribute]
class Method
{
    private array $requiredGlobalParams = [];

    /**
     * @var Params
     */
    private $params = null;

    /**
     * @var string[]
     */
    private $requiredPathParamNames = null;
    /**
     * @var Response[]
     */
    private array $responses = [];

    private ?RequestBody $requestBody = null;

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
        $this->extractParams();
        $this->extractRequestBody();
        $this->checkRequireGlobalParams();
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

    private function extractRequestBody()
    {
        $requestBody = $this->reflectionMethod->getAttributes(RequestBody::class);
        if(!empty($requestBody)) {
            $requestBody = $requestBody[0]->newInstance();
            $this->requestBody = $requestBody;
            return;
        }
    }

    private function extractParams()
    {
        $params = $this->reflectionMethod->getAttributes(Params::class);
        if(!empty($params)) {
            $params = $params[0]->newInstance();
            $this->params = $params;
        }
    }

    public function setRequiredPathParamNames(array $requiredPathParamNames)
    {
        $this->requiredPathParamNames = $requiredPathParamNames;
    }

    private function checkRequireGlobalParams()
    {
        if(is_null($this->requiredPathParamNames))
            return;

        if(is_null($this->params)){
            $this->requiredGlobalParams = $this->requiredPathParamNames;
            return;
        }
        
        $allFoundPathParamsInAttributes = $this->params->getAllInPathParams();

        foreach($this->requiredPathParamNames as $requiredParamName) {
            if(!in_array($requiredParamName, $allFoundPathParamsInAttributes)) {
                $this->requiredGlobalParams[] = $requiredParamName;
            }
        }
    }

    public function getResponses()
    {
        return $this->responses;
    }

    public function hasRequiredGlobalParams()
    {
        return !empty($this->requiredGlobalParams);
    }

    public function getRequiredGlobalParams()
    {
        return $this->requiredGlobalParams;
    }

    public function requestBodyToArray()
    {
        return empty($this->requestBody) ? [] : $this->requestBody->toArray();
    }

    public function responsesToArray()
    {
        $responses = [];
        foreach($this->responses as $response) {
            $responses[$response->getCode()] = $response->toArray();
        }

        return $responses;
    }
    
    public function paramsToArray()
    {
        return empty($this->params) ? [] : $this->params->toArray();
    }
}