<?php 
namespace DocsMaker\Attributes\Schema;

use Attribute;
use ReflectionClass;

#[Attribute]
class Schema
{
    private ReflectionClass $refClass;
    /**
     * @param string $title
     * @param "object" | "array" $type
     */
    public function __construct(
        private string $title,
        private string $type = 'object'
    )
    {}

    public function setRefClass(ReflectionClass $refClass): void
    {
        $this->refClass = $refClass;
    }
}