<?php
namespace DocsMaker\Attributes;

use DocsMaker\Attributes\Component\ComponentSchema;
use DocsMaker\Attributes\Component\Component;

class ComponentsManager
{
    private array $schemaComponents = [];

    public function setSchemas(ComponentSchema ...$schema)
    {
        $this->schemaComponents = $schema;
    }

    public function toArray()
    {
        return [
            'components' => [
                'schemas' => $this->schemasToArray()
            ]
        ];
    }

    public function schemasToArray()
    {
        $schemas = [];
        foreach($this->schemaComponents as $schema) {
            $schemas[$schema->name] = $schema->toArray();
        }

        return $schemas;
    }
}