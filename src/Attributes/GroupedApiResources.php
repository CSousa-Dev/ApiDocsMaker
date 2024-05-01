<?php 
namespace DocsMaker\Attributes;

use DocsMaker\Attributes\ApiResource;

class GroupedApiResources
{
    /**
     * @param ApiResource[] $apiResources
     */
    private $groupedResources;
    /**
     *
     * @param ApiResource[] $apiResources
     */
    public function __construct(array $apiResources)
    {
        $this->groupedResources = $this->groupApiResourcesByName($apiResources);
    }

    private function groupApiResourcesByName($apiResources)
    {
        $grouped = [];
        /**
         * @var ApiResource $apiResource
         */
        foreach($apiResources as $apiResource) {
            $apiResource->startAttributesAssembly();
            $grouped[$apiResource->name][] = $apiResource;
        }

        $groupedResources = [];
        foreach($grouped as $resources) {
            $groupedResources[] = $this->oneResourcePerName($resources);
        }

        return $groupedResources;
    }

    /**
     * @var ApiResource[] $resources
     */
    private function oneResourcePerName($resources): ApiResource
    {
        $firstResource = $resources[0];
        unset($resources[0]);

        /**
         * @var ApiResource $resource
         */
        foreach($resources as $resource) {
            if($resource->sameResource($firstResource))
                $firstResource->addResource($resource);
        }

        return $firstResource;
    }

    public function getAllPaths()
    {
        $paths = [];
        foreach($this->groupedResources as $apiResource) {
            $paths[] = array_merge($paths, $apiResource->getPaths());
        }

        return $paths;
    }

    public function foreachResourceGroupPaths()
    {
        foreach($this->groupedResources as $apiResource) {
            $apiResource->groupPathsByName();
        }
    }

    public function allPathsToArray()
    {
        $allPathsArray = [];
        foreach($this->groupedResources as $apiResource) {
            foreach($apiResource->groupedPaths() as $groupedPath) {
                $allPathsArray[$groupedPath->pathName] = $groupedPath->toArray();
            }
        }

        return $allPathsArray;
    } 
    
    public function allTagsToArray()
    {
        $tags = [];
        foreach($this->groupedResources as $apiResource) {
            $thisTag = [
                'name' => $apiResource->name,
                'description' => $apiResource->description ?? ''
            ];

            if(!empty($apiResource->externalDocsLinkName)){
                $thisTags['externalDocs'] = [
                    'description' => $apiResource->externalDocsLinkName,
                    'url' => $apiResource->linkForExternalDoc
                ];
            }

            $tags[] = $thisTag;
        }

        return $tags;
    }
}