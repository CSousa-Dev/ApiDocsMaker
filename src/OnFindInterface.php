<?php 
namespace DocsMaker;

use ReflectionClass;

interface OnFindInterface
{
    public function execute(ReflectionClass $reflection);
}