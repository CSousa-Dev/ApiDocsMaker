<?php
namespace DocsMaker\Attributes;

use Attribute;
use DocsMaker\Attributes\Parameter;

#[Attribute]
class Params
{
    /**
     * @var Parameter[]
     */
    private array $params = [];    
    public function __construct(
        Parameter ...$params
    ) 
    {
        $this->params = $params;
    }

    public function getAllInPathParams()
    {
        $inPath = [];
        /**
         * @var Parameter $param
         */
        foreach($this->params as $param) {
            if($param->isInPath()) {
                $inPath[] = $param;
            }
        }

        return $inPath;
    }

    public function toArray()
    {

        if(empty($this->params)) {
            return [];
        }

        $params = [];
        /**
         * @var Parameter $param
         */
        foreach($this->params as $param) {
            $params[] = $param->toArray();
        }

        return $params;
    }
}