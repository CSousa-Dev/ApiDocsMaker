<?php 
namespace DocsMaker\Exceptions;

use Exception;

class MultiplesApiResourcePerClassException extends Exception
{
    public function __construct()
    {
        parent::__construct('Only one ApiResource attribute is allowed per class');
    }
}