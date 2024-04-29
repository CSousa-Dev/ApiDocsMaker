<?php 
namespace DocsMaker\Attributes;

use Attribute;
use DocsMaker\Attributes\Schema\Properties\PropertyInterface;

#[Attribute]
class RequestBody
{
    public function __construct(
        public string $description,
        public readonly PropertyInterface $content,
        public readonly string $contentType = '.',
        public readonly ?string $requestRef = null,
        public readonly ?string $contentSchemaRef = null,
    ){}

    public function toArray()
    {
        $array = [
            'description' => $this->description,
            'content' => [$this->contentType => []]
        ];

        $array['content'][$this->contentType]['schema'] = $this->content->toArray();
        
        $filteredValues = [];
        foreach ($array as $key => $value) {
            if (!empty($value) && $value !== null) {
                $filteredValues[$key] = $value;
            }
        }

        return $filteredValues;
    }
}