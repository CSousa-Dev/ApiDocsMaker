<?php 
namespace DocsMaker\Attributes;

use Attribute;
use ReflectionClass;
use DocsMaker\Attributes\Parameter;
use DocsMaker\Attributes\GroupedPaths;
use DocsMaker\Exceptions\ExternalDocsWithoutLink;
use DocsMaker\Exceptions\ExternalDocsWithoutName;
use DocsMaker\Exceptions\TwoIdenticalPathsException;

#[Attribute]
class ApiResource
{
    private ReflectionClass $refClass;
    private array $globalParams;
    private array $paths = [];
    private array $groupedPaths = [];
    public function __construct(
        public readonly string $name,
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
        $this->verifyGlobalParamsHasPath();
    }

    public function setRefClass(ReflectionClass $class)
    {
        $this->refClass = $class;
    }

    private function getGlobalParamsForPath($pathName)
    {
        $params = [];
        foreach($this->globalParams as $param) {
            if($param->forPath === $pathName) {
                $params[] = $param;
            }
        }

        return $params;
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

    private function verifyGlobalParamsHasPath()
    {
        /**
         * @var Parameter $param
         */
        foreach($this->globalParams as $param) {
            if(is_null($param->forPath)) {
                throw new \Exception('Global parameters must have a path');
            }
        }
    }

    public function addResource(ApiResource $anotherResource)
    {
        $mergedPaths = array_merge($this->paths, $anotherResource->getPaths());
        $this->description .= "<br>" . $anotherResource->description;
        $mergedGlobalParams =  array_merge($this->globalParams, $anotherResource->globalParams);
        $this->paths = $mergedPaths;
        $this->globalParams = $mergedGlobalParams;
        $this->checkHasIdenticalPathAndMethod();    
    }

    public function sameResource(ApiResource $apiResource)
    {
        return $this->name === $apiResource->name;
    }

    public function groupPathsByName()
    {
        $grouped = [];
        foreach($this->paths as $path) {
            $grouped[$path->name][] = $path;
        }

        foreach($grouped as $pathName => $paths) {
            $groupedPath = new GroupedPaths($pathName, $this->name, ...$paths);
            $groupedPath->setGlobalParams(...$this->getGlobalParamsForPath($pathName));
            $this->groupedPaths[] = new GroupedPaths($pathName, $this->name, ...$paths);
        }
    }

    public function groupedPaths()
    {
        return $this->groupedPaths;
    }
}