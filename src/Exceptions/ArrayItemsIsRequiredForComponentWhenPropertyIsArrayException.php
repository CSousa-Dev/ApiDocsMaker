<?php 
namespace DocsMaker\Exceptions;

use Exception;

class ArrayItemsIsRequiredForComponentWhenPropertyIsArrayException extends Exception
{
    public function __construct()
    {
        parent::__construct('Array items is required for component when property is array or object.');
    }
}