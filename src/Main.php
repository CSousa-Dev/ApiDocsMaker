<?php 

namespace DocsMaker;
use Symfony\Component\Yaml\Yaml;
use DocsMaker\Attributes\ApiResource;
use DocsMaker\Attributes\ResourceManager;
use DocsMaker\Attributes\ComponentsManager;
use DocsMaker\Attributes\Component\ComponentSchema;
use DocsMaker\Attributes\GroupedApiResources;

class Main
{
    private $config;
    public function __construct()
    {
        $configPath = __DIR__ . '/../config.apidocs.yaml';
        $this->config = Yaml::parse(file_get_contents($configPath));
    }

    public function exec()
    {
        $attributesFinder = new AttributeFinder(
            $this->config['root_namespace'],
            $this->config['root_dir']);

        $attributesFinder->findAttribute(new OnFindApiResource(), ApiResource::class);
        $apiResources = $attributesFinder->match();

        $attributesFinder->findAttribute(new OnFindComponentSchema(), ComponentSchema::class);
        $schemaComponents = $attributesFinder->match();

        $groupedResources = new GroupedApiResources($apiResources);
        $resourceManager  = new ResourceManager($groupedResources);
        $componentManager = new ComponentsManager();
        $componentManager->setSchemas(...$schemaComponents);
        
        $tagsAndPaths = $resourceManager->toArray();
        $components = $componentManager->toArray();

        $data = array_merge($tagsAndPaths, $components);

        $yaml = Yaml::dump($data, 16, 2);
        $filename = $this->config['output_dir'] . '/apidocs.yaml';

        file_put_contents($filename, $yaml);
    }
}