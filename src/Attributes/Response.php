<?php 
namespace DocsMaker\Attributes;

use Attribute;
use DocsMaker\Attributes\Schema\Properties\PropertyInterface;

#[Attribute]
class Response
{
    public function __construct(
        public int $statusCode,
        public string $description,
        public ?string $contentType = '',
        public PropertyInterface | Ref | null $content = null,
    ){
        if(($contentType == '' || $contentType == null) && $content != null)
            throw new \InvalidArgumentException('contentType is required when content is not null');
    }

    public function getCode()
    {
        return $this->statusCode;
    }

    public function toArray()
    {
        if($this->content instanceof PropertyInterface)
            $contentKey = 'schema'; 
        
        if($this->content instanceof Ref)
            $contentKey = '$ref';

        if(is_string($this->content))
            $contentKey = 'example';
    
        $array = [
            'description' => (string)$this->description,
            'content' => $this->contentType ? [$this->contentType => []] : []
        ];
        
        if(isset($contentKey) && !empty($contentKey))
            $array['content'][$this->contentType][$contentKey] = $this->makeContent();


        $filteredValues = [];
        foreach ($array as $key => $value) {
            if (!empty($value) && $value !== null) {
                $filteredValues[$key] = $value;
            }
        }

        return $filteredValues;
    }

    private function makeContent()
    {
        if($this->content instanceof PropertyInterface) {
            return $this->content->toArray();
        }

        if($this->content instanceof Ref) {
            return  $this->content->name;
        }

        if(is_string($this->content)) {
            return $this->content;
        }

        return null;
    }
}