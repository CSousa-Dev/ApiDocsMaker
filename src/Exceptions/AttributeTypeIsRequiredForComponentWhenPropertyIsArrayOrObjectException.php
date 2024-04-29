<?php 
namespace DocsMaker\Exceptions;

use Exception;

class AttributeTypeIsRequiredForComponentWhenPropertyIsArrayOrObjectException extends Exception
{
    public function __construct()
    {
        parent::__construct('Referenced class is required for component when property type is object, or is array and inside type is object.');
    }
}