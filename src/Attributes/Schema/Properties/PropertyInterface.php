<?php 
namespace DocsMaker\Attributes\Schema\Properties;

Interface PropertyInterface
{
    public function type(): string;
    public function toArray(): array;
}