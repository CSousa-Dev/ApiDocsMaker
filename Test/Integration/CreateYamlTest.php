<?php

use DocsMaker\Main;
use PHPUnit\Framework\TestCase;

class CreateYamlTest extends TestCase
{
    public function testCreateYaml()
    {
        $main = new Main();
        $main->exec();
    }
}