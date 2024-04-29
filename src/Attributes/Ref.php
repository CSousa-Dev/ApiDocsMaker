<?php 
namespace DocsMaker\Attributes;

class Ref
{
    public readonly string $name;
    /**
     * The class is used to reference other classes that have the attributes: Response, Schema, ContentBody, or Headers. Keep in mind that the referenced class must contain at least one of these attributes to be properly referenced.
     *
     * @param string $class
     */
    public function __construct(string $class)
    {
        $this->name = $class::getRefName();
    } 
}