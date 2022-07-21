<?php

namespace Dxw\WordPressSetup;

class Setup
{
    private $modules = [];

    public function __construct(array $modules)
    {
        foreach ($modules as $name => $module) {
            $this->modules[$name] = $module;
        }
    }

    public function __get($name)
    {
        return $this->modules[$name];
    }
}
