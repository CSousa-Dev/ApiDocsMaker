<?php 
namespace DocsMaker\Attributes;

use Attribute;
use DocsMaker\Attributes\Schema\InlineSchema;

#[Attribute]
class RequestBody
{
    public function __construct(
        public int $statusCode,
        public string $description,
        public ?string $contentType = 'application/json',
        public InlineSchema | Ref | string | null $content = null,
    )
    {
    }
}