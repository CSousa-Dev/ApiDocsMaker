<?php 
namespace DocsMaker\Exceptions;

use Exception;

class OnlyObjectTypedPropComponentsCanReceiveComponentReferenceException extends Exception
{
    public function __construct()
    {
        parent::__construct('Only object or array typed prop components can receive component reference.');
    }
}