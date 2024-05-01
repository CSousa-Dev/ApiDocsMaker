<?php
namespace DocsMaker\Attributes;

use DocsMaker\Attributes\ResourcePath;
use DocsMaker\Attributes\GroupedApiResources;
use DocsMaker\Exceptions\TwoIdenticalPathsException;

class ResourceManager
{
    public function __construct(
        private GroupedApiResources $groupedApiResources
    ){
        $this->searchForIdenticalPathsAndMethodsInAllResources();
        $this->groupedApiResources->foreachResourceGroupPaths();
    }

    private function searchForIdenticalPathsAndMethodsInAllResources()
    {
        $allPaths = [];
        foreach($this->groupedApiResources as $groupedResource) {
            $allPaths = array_merge($allPaths, $groupedResource->getAllPaths());
        }

        $this->checkHasIdenticalPathAndMethod($allPaths);
    }

    private function checkHasIdenticalPathAndMethod($paths)
    {
        $pathsAndMethods = [];
        /**
         * @var ResourcePath $path
         */
        foreach($paths as $path) {
            if(in_array($path->getMethod()->getName() . $path->name, $pathsAndMethods)) {
                throw new TwoIdenticalPathsException($path->name, $path->getMethod()->getName());
            }
            $pathsAndMethods[] = $path->getMethod()->getName() . $path->name;
        }
    }

    public function toArray()
    {
        return [ 
            'tags' => $this->groupedApiResources->allTagsToArray(),
            'paths' => $this->groupedApiResources->allPathsToArray()
        ];
    }
}