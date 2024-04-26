<?php 

namespace DocsMaker\Exceptions;

use Exception;

class MethodWithoutResponsesException extends Exception
{
    public function __construct(string $path, string $method)
    {
        parent::__construct("Path $path with method " . strtoupper($method) . " does not have any responses. At least one response is required.");
    }
}