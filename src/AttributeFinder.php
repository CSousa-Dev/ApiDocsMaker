<?php 
namespace DocsMaker;

use ReflectionClass;
use DocsMaker\OnFindInterface;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use DocsMaker\Attributes\ApiResource;

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
        $this->resource = [];
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

                $baseNamespace = explode('\\', $namespace)[0];

                if($this->namespace != $baseNamespace) {
                    continue;
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

    public function match(): array
    {
        return $this->resource;
    }

}