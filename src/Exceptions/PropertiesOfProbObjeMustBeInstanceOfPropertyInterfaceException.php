<?php 
namespace DocsMaker\Exceptions;

use Exception;

class PropertiesOfProbObjeMustBeInstanceOfPropertyInterfaceException extends Exception
{
    public function __construct()
    {
        parent::__construct("All properties of object must be instance of PropertyInterface");
    }
}