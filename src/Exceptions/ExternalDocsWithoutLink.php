<?php 

namespace DocsMaker\Exceptions;

use Exception;
class ExternalDocsWithoutLink extends Exception
{
    public function __construct()
    {
        parent::__construct('If you want to use externalDocsLinkName, you need to pass linkForExternalDocumentation.');
    }
}