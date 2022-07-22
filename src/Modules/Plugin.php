<?php

namespace Dxw\WordPressSetup\Modules;

class Plugin
{
    public function activate($slug)
    {
        \WP_CLI::runcommand('plugin activate ' . $slug);
    }
}
