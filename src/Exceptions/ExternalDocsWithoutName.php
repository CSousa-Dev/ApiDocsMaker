<?php 

namespace DocsMaker\Exceptions;

use Exception;
class ExternalDocsWithoutName extends Exception
{
    public function __construct()
    {
        parent::__construct('If you want to use linkForExternalDocumentation, you need to pass externalDocsLinkName.');
    }
}