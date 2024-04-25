<?php 
namespace DocsMaker;

use ReflectionClass;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use DocsMaker\OnFindApiResource;
use DocsMaker\Attributes\ApiResource;

class FindAttributes 
{
    private array $apiResources = [];
    public function __construct(
        private string $rootDir
    )
    {
        $this->find();
    }

    private function find()
    {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->rootDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $file) {
            if ($file->getExtension() === 'php') {
                require_once $file->getPathname();
    
                foreach (get_declared_classes() as $className) {
                    $teste = get_include_path();
                    $reflectionClass = new ReflectionClass($className);
                    $classInitialDirectory = str_replace('\\', '/', $reflectionClass->getNamespaceName());
                   
                }
            }
        }
    }

    public function apiResources(): array
    {
        return $this->apiResources;
    }
}