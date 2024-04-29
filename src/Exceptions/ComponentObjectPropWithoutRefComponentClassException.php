<?php 

namespace DocsMaker\Exceptions;

use Exception;

class ComponentObjectPropWithoutRefComponentClassException extends Exception
{
    public function __construct()
    {
        parent::__construct('Referenced class is required for component when property type is object.');
    }
}