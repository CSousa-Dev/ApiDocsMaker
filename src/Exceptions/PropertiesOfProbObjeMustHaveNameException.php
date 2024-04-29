<?php 
namespace DocsMaker\Exceptions;

use Exception;

class PropertiesOfProbObjeMustHaveNameException extends Exception
{
    public function __construct()
    {
        parent::__construct('All properties of an object must have a name');
    }
}