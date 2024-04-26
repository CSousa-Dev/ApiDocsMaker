<?php 
namespace DocsMaker\Exceptions;

use Exception;
class TwoIdenticalPathsException extends Exception
{
    public function __construct(string $path, string $method)
    {
        parent::__construct("Two identical paths: $path and method ". strtoupper($method) ." found in the same resource. Please make sure that each path is unique.");
    }
}