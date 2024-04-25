<?php 
namespace DocsMaker\Exceptions;

use Exception;

class InvalidMethodException extends Exception
{
    public function __construct()
    {
        parent::__construct("An HTTP method must be a valid method among 'GET', 'POST', 'PUT', 'DELETE', 'PATCH'.");
    }
}