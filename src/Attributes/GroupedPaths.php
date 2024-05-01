<?php 
namespace DocsMaker\Attributes;

use DocsMaker\Attributes\ResourcePath;
use DocsMaker\Attributes\Parameter;

class GroupedPaths
{
    /**
     * @var ResourcePath[]
     */
    private array $paths = [];

    private array $globalParams = [];

    public function __construct(
        public readonly string $pathName, 
        private readonly string $tag,
        ResourcePath ...$resourcePath
    ){
        $this->paths = $resourcePath;
    }

    public function getPaths()
    {
        return $this->paths;
    }

    public function getPathName()
    {
        return $this->pathName;
    }

    public function setGlobalParams(?Parameter ...$paramenter)
    {
        $this->globalParams = $paramenter;
    }

    public function getGlobalParamns()
    {
        return $this->globalParams;
    }

    public function toArray()
    {
        $allPathMethods = [];

        /**
         * @var ResourcePath $path
         */
        foreach($this->paths as $path) {
            $allPathMethods[strtolower($path->getMethod()->getName())] = $this->pathToArray($path);
        }

        $globalParams = $this->globalParamsToArray();

        $data = [
            'parameters' => $globalParams,
            ...$allPathMethods
        ];

        return array_filter($data, function($value) {
            return !empty($value);
        });
    }

    private function pathToArray(ResourcePath $path)
    {
        $method = $path->getMethod();
        $pathInformations = [
                'tags' => [$this->tag],
                'summary' => $path->sumary,
                'description' => $path->description,
                'parameters' => $method->paramsToArray(),
                'requestBody' => $method->requestBodyToArray(),
                'responses' => $method->responsesToArray()
        ];

        $filteredArray = array_filter($pathInformations, function($value) {
            return !empty($value);
        });

        return $filteredArray;
    }

    private function globalParamsToArray()
    {
        if(empty($this->globalParams)) {
            return [];
        }

        $params = new Params(...$this->globalParams);
        return $params->toArray();
    }
}