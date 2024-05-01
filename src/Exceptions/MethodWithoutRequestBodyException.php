<?php 
namespace DocsMaker\Exceptions;

use Exception;

class MethodWithoutRequestBodyException extends Exception
{
    public function __construct($declaringClass, $methodName)
    {
        parent::__construct('Method without request body in method '.$methodName .' in class ' . $declaringClass);
    }
}