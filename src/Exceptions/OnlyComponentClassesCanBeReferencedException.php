<?php 
namespace DocsMaker\Exceptions;

use Exception;

class OnlyComponentClassesCanBeReferencedException extends Exception
{
    public function __construct(string $className)
    {
        parent::__construct("Only classes with #[ComponentSchema] attribute can be referenced. Class $className does not have #[ComponentSchema] attribute.");
    }
}