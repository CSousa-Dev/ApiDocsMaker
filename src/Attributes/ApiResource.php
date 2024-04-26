<?php 
namespace DocsMaker\Attributes;

use Attribute;
use ReflectionClass;
use DocsMaker\Attributes\Parameter;
use DocsMaker\Exceptions\ExternalDocsWithoutLink;
use DocsMaker\Exceptions\ExternalDocsWithoutName;
use DocsMaker\Exceptions\TwoIdenticalPathsException;

#[Attribute]
class ApiResource
{
    private ReflectionClass $refClass;
    private array $globalParams;
    private array $paths = [];
    public function __construct(
        public string $name,
        public string $description,
        public ?string $linkForExternalDoc = null,
        public ?string $externalDocsLinkName = null,
        ?Parameter ...$globalParams
    ) {
        if(is_null($linkForExternalDoc) && !is_null($externalDocsLinkName)) {
            throw new ExternalDocsWithoutLink();
        }

        if(!is_null($linkForExternalDoc) && is_null($externalDocsLinkName)) {
            throw new ExternalDocsWithoutName();
        }

        $this->globalParams = $globalParams;
    }

    public function setRefClass(ReflectionClass $class)
    {
        $this->refClass = $class;
    }

    public function startAttributesAssembly()
    {
        $methods = $this->refClass->getMethods();

        foreach($methods as $method) {
            $pathAttribute = $method->getAttributes(ResourcePath::class);
            
            if(empty($pathAttribute)) {
                continue;
            }

            if(count($pathAttribute) > 1) {
                throw new \Exception('Only one ResourcePath attribute is allowed per method');
            }

            $path = $pathAttribute[0]->newInstance();
            /** @var ResourcePath $path */
            $path->setRefMethod($method);
            $path->startAttributesAssembly();
            $this->paths[] = $path;
        }

        $this->checkHasIdenticalPathAndMethod();
    }

    private function checkHasIdenticalPathAndMethod()
    {
        $pathsAndMethods = [];
        /**
         * @var ResourcePath $path
         */
        foreach($this->paths as $path) {
            if(in_array($path->getMethod()->getName() . $path->name, $pathsAndMethods)) {
                throw new TwoIdenticalPathsException($path->name, $path->getMethod()->getName());
            }
            $pathsAndMethods[] = $path->getMethod()->getName() . $path->name;
        }
    }

    public function getPaths()
    {
        return $this->paths;
    }
}