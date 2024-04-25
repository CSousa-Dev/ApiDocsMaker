<?php 
namespace DocsMaker;

use ReflectionClass;
use DocsMaker\OnFindInterface;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class AttributeFinder {
    
    private $resource = [];
    protected $namespace;
    protected $rootPath;
    
    public function __construct($namespace, $rootPath) {
        $this->namespace = $namespace;
        $this->rootPath = $rootPath;
    }
    
    public function findAttribute(OnFindInterface $onFindInterface, $attributeName)
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->rootPath, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $file) {
            if ($file->getExtension() === 'php') {
                $content = file_get_contents($file->getPathname());
                if (preg_match('/namespace\s+(.*?);/s', $content, $matchesNamespace)) {
                    $namespace = $matchesNamespace[1];
                } else {
                    $namespace = '';
                }
                
                if (preg_match('/class\s+(\w+)/', $content, $matchesClass)) {
                    $className = $matchesClass[1];
                    
                    // Carrega a classe usando ReflectionClass
                    $fullClassName = $namespace ? $namespace . '\\' . $className : $className;
                    $reflectionClass = new ReflectionClass($fullClassName);

                    if($reflectionClass->getAttributes($attributeName)) {
                        $this->resource[] = $onFindInterface->execute($reflectionClass);
                    }
                }
            }
        }
    }

    public function resources(): array
    {
        return $this->resource;
    }

}