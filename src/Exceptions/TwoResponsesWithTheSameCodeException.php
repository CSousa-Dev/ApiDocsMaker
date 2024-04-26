<?php 
namespace DocsMaker\Exceptions;

use Exception;
class TwoResponsesWithTheSameCodeException extends Exception
{
    public function __construct(string $code, string $method, string $path)
    {
        parent::__construct("Two responses with the same code: $code for the same method ". $method . " in path " . $path . ". Each response code must be unique.");
    }
}