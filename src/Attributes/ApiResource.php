<?php 
namespace DocsMaker\Attributes;

use Attribute;
use DocsMaker\Exceptions\ExternalDocsWithoutLink;
use DocsMaker\Exceptions\ExternalDocsWithoutName;
use ReflectionClass;

#[Attribute]
class ApiResource
{
    private ReflectionClass $refClass;
    public function __construct(
        public string $name,
        public string $description,
        public ?string $linkForExternalDoc = null,
        public ?string $externalDocsLinkName = null
    ) {
        if(is_null($linkForExternalDoc) && !is_null($externalDocsLinkName)) {
            throw new ExternalDocsWithoutLink();
        }

        if(!is_null($linkForExternalDoc) && is_null($externalDocsLinkName)) {
            throw new ExternalDocsWithoutName();
        }
    }

    public function setRefClass(ReflectionClass $class)
    {
        $this->refClass = $class;
    }
}